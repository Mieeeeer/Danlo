<?php
include 'db.php';

// Get content statistics
if (isset($Content)) {
    $total_news = $Content->count(['type' => 'news']);
    $published_news = $Content->count(['type' => 'news', 'status' => 'published']);
    $total_blogs = $Content->count(['type' => 'blog_post']);
    $total_fb_posts = $Content->count(['type' => 'facebook_post']);
} else {
    $total_news = 0;
    $published_news = 0;
    $total_blogs = 0;
    $total_fb_posts = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Content Management</title>
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

        .admin-dashboard {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-card h3 {
            margin: 0 0 1rem 0;
            color: #333;
        }

        .dashboard-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .dashboard-card .icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #EB0000;
        }

        .dashboard-card .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #EB0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .dashboard-card .btn:hover {
            background: #cc0000;
        }

        .stats-container {
            background: #f5f5f5;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .stat-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            text-align: center;
        }

        .stat-card h4 {
            margin: 0;
            color: #666;
        }

        .stat-card .number {
            font-size: 1.5rem;
            font-weight: bold;
            color: #EB0000;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="admin-dashboard.php" class="active">Dashboard</a></li>
                <li><a href="admin-news.php">News</a></li>
                <li><a href="admin-facebook.php">Facebook</a></li>
                <li><a href="admin-blog.php">Blog</a></li>
                <li><a href="home.php">View Site</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="admin-dashboard">
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
                
        <div class="stats-container">
            <h2>Quick Stats</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h4>Total News</h4>
                    <div class="number"><?php echo $total_news; ?></div>
                </div>
                <div class="stat-card">
                    <h4>Published News</h4>
                    <div class="number"><?php echo $published_news; ?></div>
                </div>
                <div class="stat-card">
                    <h4>Blog Articles</h4>
                    <div class="number"><?php echo $total_blogs; ?></div>
                </div>
                <div class="stat-card">
                    <h4>FB Posts</h4>
                    <div class="number"><?php echo $total_fb_posts; ?></div>
                </div>
            </div>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <i class='bx bx-news icon'></i>
                <h3>News Management</h3>
                <p>Create and manage school news articles and announcements.</p>
                <a href="admin-news.php" class="btn">Manage News</a>
            </div>

            <div class="dashboard-card">
                <i class='bx bxl-facebook-circle icon'></i>
                <h3>Facebook Posts</h3>
                <p>Embed and manage Facebook posts on the website.</p>
                <a href="admin-facebook.php" class="btn">Manage FB Posts</a>
            </div>

            <div class="dashboard-card">
                <i class='bx bxl-blogger icon'></i>
                <h3>Blog Management</h3>
                <p>Write and publish blog articles about school events and activities.</p>
                <a href="admin-blog.php" class="btn">Manage Blog</a>
            </div>

            <div class="dashboard-card">
                <i class='bx bx-images icon'></i>
                <h3>Media Library</h3>
                <p>Upload and manage images and other media files.</p>
                <a href="admin-media.php" class="btn">Manage Media</a>
            </div>
        </div>
    </main>

    <footer>
        <div class="copyright">
            <p>Copyright © 2025 Sta. Ana Central Elementary School. All Rights Reserved</p>
        </div>
    </footer>
</body>
</html> 