<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    $_SESSION['login_error'] = "You must log in to access this page.";
    exit();
}


include 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create' || $_POST['action'] === 'update') {
            $post_url = $_POST['post_url'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $status = $_POST['status'];
            $display_pages = isset($_POST['display_pages']) ? $_POST['display_pages'] : [];
            
            // Extract post ID from Facebook URL
            preg_match('/posts\/([^?&]+)/', $post_url, $matches);
            $post_id = $matches[1] ?? '';
            
            $fbData = [
                'type' => 'facebook_post',
                'post_url' => $post_url,
                'post_id' => $post_id,
                'description' => $description,
                'location' => $location,
                'status' => $status,
                'display_pages' => $display_pages,
                'created_at' => new MongoDB\BSON\UTCDateTime(),
                'updated_at' => new MongoDB\BSON\UTCDateTime()
            ];

            if ($_POST['action'] === 'create') {
                $result = $Content->insertOne($fbData);
                
                // Add to AnnouncementLink collection
                if ($result->getInsertedId()) {
                    foreach ($display_pages as $page) {
                        $school_level = ($page === 'elementary') ? 'elementary' : 'highschool';
                        $announcementData = [
                            'type' => 'announcement',
                            'school_level' => $school_level,
                            'iframe_link' => $post_url,
                            'created_at' => new MongoDB\BSON\UTCDateTime()
                        ];
                        $AnnouncementLink->insertOne($announcementData);
                    }
                }
            } else {
                $Content->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($_POST['post_id'])],
                    ['$set' => $fbData]
                );
                
                // Update AnnouncementLink entries
                foreach ($display_pages as $page) {
                    $school_level = ($page === 'elementary') ? 'elementary' : 'highschool';
                    $existingAnnouncement = $AnnouncementLink->findOne([
                        'type' => 'announcement',
                        'school_level' => $school_level,
                        'iframe_link' => $post_url
                    ]);
                    
                    if (!$existingAnnouncement) {
                        $announcementData = [
                            'type' => 'announcement',
                            'school_level' => $school_level,
                            'iframe_link' => $post_url,
                            'created_at' => new MongoDB\BSON\UTCDateTime()
                        ];
                        $AnnouncementLink->insertOne($announcementData);
                    }
                }
            }
        } elseif ($_POST['action'] === 'delete' && isset($_POST['post_id'])) {
            // Get the post URL before deleting
            $post = $Content->findOne(['_id' => new MongoDB\BSON\ObjectId($_POST['post_id'])]);
            if ($post && isset($post['post_url'])) {
                // Delete corresponding announcement links
                $AnnouncementLink->deleteMany([
                    'type' => 'announcement',
                    'iframe_link' => $post['post_url']
                ]);
            }
            // Delete the post itself
            $Content->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_POST['post_id'])]);
        }
    }
    header('Location: admin-facebook.php');
    exit;
}

// Get all Facebook posts
$fb_posts = $Content->find(['type' => 'facebook_post'], [
    'sort' => ['created_at' => -1]
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facebook Posts Management - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Navigation Styles */
        .nav-container {
            background-color: #363535;
            width: 100%;
            padding: 0.5rem 0;
        }

        .nav-container ul {
            list-style: none;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            margin: 0;
            padding: 0;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-container li {
            padding: 0.5rem 0;
        }

        .nav-container a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-container a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-container a.active {
            background-color: #8c0000;
            color: white;
        }

        /* Logo Section Styles */
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .logo-section img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .dashboard-title {
            font-size: 2rem;
            color: #333;
            margin: 0;
            text-align: center;
            flex: 1;
            padding: 0 2rem;
        }

        /* Copyright Styles */
        .copyright {
            margin-top: 0;
            width: 100%;
            padding-top: 1rem;
            text-align: center;
        }

        .copyright p {
            margin: 0;
            padding: 1rem 0;
        }

        .fb-management {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .fb-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        .fb-list {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .fb-form {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 2rem;
        }

        .fb-post {
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }

        .fb-post:last-child {
            border-bottom: none;
        }

        .fb-post h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }

        .fb-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .fb-preview {
            margin: 1rem 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .fb-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-edit, .btn-delete {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
        }

        .btn-edit {
            background: #007bff;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .checkbox-group {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .btn-submit {
            background: #28a745;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #218838;
        }

        .status-draft {
            color: #6c757d;
        }

        .status-published {
            color: #28a745;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="admin-news.php">News</a></li>
                <li><a href="admin-facebook.php" class="active">Facebook</a></li>
                <li><a href="admin-blog.php">Blog</a></li>
                <li><a href="home.php">View Site</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="logo-section">
        <?php      
            $elemLogo = $Logo->findOne([
                'title' => 'elem_logo'
            ]);
            if ($elemLogo && isset($elemLogo['img_path'])) {
                echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Elem Logo">';
            }
        ?>
        <h1 class="dashboard-title">Sta. Ana Content Management Dashboard</h1>
        <img src="images/Sta. Ana High logo.png" alt="Sta. Ana High Logo" style="width:100px;height:100px;object-fit:contain;">
    </div>

    <main class="fb-management">
        <h1>Facebook Posts Management</h1>
        
        <div class="fb-grid">
            <div class="fb-list">
                <h2>Embedded Posts</h2>
                <?php foreach ($fb_posts as $post): ?>
                    <div class="fb-post">
                        <h3><?php echo htmlspecialchars($post['description']); ?></h3>
                        <div class="fb-meta">
                            <span class="status-<?php echo $post['status']; ?>">
                                <?php echo ucfirst($post['status']); ?>
                            </span>
                            | Location: <?php echo htmlspecialchars($post['location']); ?>
                            | <?php echo $post['created_at']->toDateTime()->format('M j, Y'); ?>
                        </div>
                        <div class="fb-preview">
                            <iframe src="https://www.facebook.com/plugins/post.php?href=<?php echo urlencode($post['post_url']); ?>&show_text=true&width=500" 
                                    width="500" height="400" style="border:none;overflow:hidden" scrolling="no" frameborder="0" 
                                    allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                            </iframe>
                        </div>
                        <div class="fb-actions">
                            <button class="btn-edit" onclick="editPost(<?php echo htmlspecialchars(json_encode($post)); ?>)">Edit</button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="post_id" value="<?php echo $post['_id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="fb-form">
                <h2>Add Facebook Post</h2>
                <form method="POST" id="fbForm">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="post_id" id="editPostId">
                    
                    <div class="form-group">
                        <label for="post_url">Facebook Post URL</label>
                        <input type="url" id="post_url" name="post_url" class="form-control" required
                               placeholder="https://www.facebook.com/username/posts/123456789">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="location">Display Location</label>
                        <select id="location" name="location" class="form-control" required>
                            <option value="homepage">Homepage</option>
                            <option value="announcements">Announcements Page</option>
                            <option value="sidebar">Sidebar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Display on Pages</label>
                        <div class="checkbox-group">
                            <label>
                                <input type="checkbox" name="display_pages[]" value="home" checked> Homepage
                            </label>
                            <label>
                                <input type="checkbox" name="display_pages[]" value="elementary"> Elementary
                            </label>
                            <label>
                                <input type="checkbox" name="display_pages[]" value="highschool"> High School
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-submit">Add Post</button>
                </form>
            </div>
        </div>
    </main>

    <footer>
        <div class="copyright">
            <p>Copyright © 2025 Sta. Ana Central Elementary School. All Rights Reserved</p>
        </div>
    </footer>

    <script>
        function editPost(post) {
            document.getElementById('fbForm').action.value = 'update';
            document.getElementById('editPostId').value = post._id;
            document.getElementById('post_url').value = post.post_url;
            document.getElementById('description').value = post.description;
            document.getElementById('location').value = post.location;
            document.getElementById('status').value = post.status;

            // Update checkboxes
            const checkboxes = document.querySelectorAll('input[name="display_pages[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = post.display_pages && post.display_pages.includes(checkbox.value);
            });

            document.querySelector('.btn-submit').textContent = 'Update Post';
            document.querySelector('.fb-form h2').textContent = 'Edit Facebook Post';
        }
    </script>
</body>
</html> 