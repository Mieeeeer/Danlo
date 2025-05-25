<?php

session_start();

// Redirect if already logged in
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
            $title = $_POST['title'];
            $content = $_POST['content'];
            $excerpt = $_POST['excerpt'];
            $author = $_POST['author'];
            $category = $_POST['category'];
            $tags = array_filter(array_map('trim', explode(',', $_POST['tags'])));
            $status = $_POST['status'];
            $display_pages = isset($_POST['display_pages']) ? $_POST['display_pages'] : [];
            
            // Handle featured image upload
            $featured_image = '';
            if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = 'uploads/blog/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_extension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $upload_path)) {
                    $featured_image = $upload_path;
                }
            }
            
            $blogData = [
                'type' => 'blog_post',
                'title' => $title,
                'content' => $content,
                'excerpt' => $excerpt,
                'author' => $author,
                'category' => $category,
                'tags' => $tags,
                'status' => $status,
                'display_pages' => $display_pages,
                'created_at' => new MongoDB\BSON\UTCDateTime(),
                'updated_at' => new MongoDB\BSON\UTCDateTime()
            ];
            
            if ($featured_image) {
                $blogData['featured_image'] = $featured_image;
            }

            if ($_POST['action'] === 'create') {
                $result = $Content->insertOne($blogData);
                
                // Add to AnnouncementLink collection
                if ($result->getInsertedId()) {
                    foreach ($display_pages as $page) {
                        $school_level = ($page === 'elementary') ? 'elementary' : 'highschool';
                        $announcementData = [
                            'type' => 'announcement',
                            'school_level' => $school_level,
                            'iframe_link' => "blog.php?id=" . $result->getInsertedId(),
                            'created_at' => new MongoDB\BSON\UTCDateTime()
                        ];
                        $AnnouncementLink->insertOne($announcementData);
                    }
                }
            } else {
                $Content->updateOne(
                    ['_id' => new MongoDB\BSON\ObjectId($_POST['blog_id'])],
                    ['$set' => $blogData]
                );
                
                // Update AnnouncementLink entries
                foreach ($display_pages as $page) {
                    $school_level = ($page === 'elementary') ? 'elementary' : 'highschool';
                    $existingAnnouncement = $AnnouncementLink->findOne([
                        'type' => 'announcement',
                        'school_level' => $school_level,
                        'iframe_link' => "blog.php?id=" . $_POST['blog_id']
                    ]);
                    
                    if (!$existingAnnouncement) {
                        $announcementData = [
                            'type' => 'announcement',
                            'school_level' => $school_level,
                            'iframe_link' => "blog.php?id=" . $_POST['blog_id'],
                            'created_at' => new MongoDB\BSON\UTCDateTime()
                        ];
                        $AnnouncementLink->insertOne($announcementData);
                    }
                }
            }
        } elseif ($_POST['action'] === 'delete' && isset($_POST['blog_id'])) {
            $Content->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_POST['blog_id'])]);
        }
    }
    header('Location: admin-blog.php');
    exit;
}

// Get all blog posts
$blog_posts = $Content->find(['type' => 'blog_post'], [
    'sort' => ['created_at' => -1]
]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 400,
            images_upload_url: 'upload.php',
            automatic_uploads: true
        });
    </script>
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

        .blog-management {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        .blog-list {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .blog-form {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 2rem;
        }

        .blog-post {
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }

        .blog-post:last-child {
            border-bottom: none;
        }

        .blog-post h3 {
            margin: 0 0 0.5rem 0;
            color: #333;
        }

        .blog-meta {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .blog-excerpt {
            color: #666;
            margin: 1rem 0;
        }

        .blog-tags {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin: 0.5rem 0;
        }

        .blog-tag {
            background: #f0f0f0;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            color: #666;
        }

        .blog-actions {
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

        .featured-image {
            max-width: 200px;
            margin: 1rem 0;
            border-radius: 4px;
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
                <li><a href="admin-facebook.php">Facebook</a></li>
                <li><a href="admin-blog.php" class="active">Blog</a></li>
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

    <main class="blog-management">
        <h1>Blog Management</h1>
        
        <div class="blog-grid">
            <div class="blog-list">
                <h2>Blog Posts</h2>
                <?php foreach ($blog_posts as $post): ?>
                    <div class="blog-post">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <div class="blog-meta">
                            <span class="status-<?php echo $post['status']; ?>">
                                <?php echo ucfirst($post['status']); ?>
                            </span>
                            | By <?php echo htmlspecialchars($post['author']); ?>
                            | Category: <?php echo htmlspecialchars($post['category']); ?>
                            | <?php echo $post['created_at']->toDateTime()->format('M j, Y'); ?>
                        </div>
                        <?php if (isset($post['featured_image'])): ?>
                            <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" alt="Featured Image" class="featured-image">
                        <?php endif; ?>
                        <div class="blog-excerpt">
                            <?php echo htmlspecialchars($post['excerpt']); ?>
                        </div>
                        <?php if (!empty($post['tags'])): ?>
                            <div class="blog-tags">
                                <?php foreach ($post['tags'] as $tag): ?>
                                    <span class="blog-tag"><?php echo htmlspecialchars($tag); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="blog-actions">
                            <button class="btn-edit" onclick="editPost(<?php echo htmlspecialchars(json_encode($post)); ?>)">Edit</button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="blog_id" value="<?php echo $post['_id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="blog-form">
                <h2>Create Blog Post</h2>
                <form method="POST" id="blogForm" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="blog_id" id="editBlogId">
                    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="featured_image">Featured Image</label>
                        <input type="file" id="featured_image" name="featured_image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-group">
                        <label for="excerpt">Excerpt</label>
                        <textarea id="excerpt" name="excerpt" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" class="form-control" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" id="author" name="author" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="school-events">School Events</option>
                            <option value="student-life">Student Life</option>
                            <option value="academics">Academics</option>
                            <option value="achievements">Achievements</option>
                            <option value="announcements">Announcements</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags (comma-separated)</label>
                        <input type="text" id="tags" name="tags" class="form-control" placeholder="event, sports, academic">
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

                    <button type="submit" class="btn-submit">Create Post</button>
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
            document.getElementById('blogForm').action.value = 'update';
            document.getElementById('editBlogId').value = post._id;
            document.getElementById('title').value = post.title;
            document.getElementById('excerpt').value = post.excerpt;
            tinymce.get('content').setContent(post.content);
            document.getElementById('author').value = post.author;
            document.getElementById('category').value = post.category;
            document.getElementById('tags').value = post.tags.join(', ');
            document.getElementById('status').value = post.status;

            // Update checkboxes
            const checkboxes = document.querySelectorAll('input[name="display_pages[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = post.display_pages && post.display_pages.includes(checkbox.value);
            });

            document.querySelector('.btn-submit').textContent = 'Update Post';
            document.querySelector('.blog-form h2').textContent = 'Edit Blog Post';
        }
    </script>
</body>
</html> 