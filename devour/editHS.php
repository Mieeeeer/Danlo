<?php
// admin.php - Content Management System for Sta. Ana National High School
include 'db.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'update_text':
            updateTextContent();
            break;
        case 'update_image':
            updateImageContent();
            break;
        case 'update_logo':
            updateLogo();
            break;
        case 'update_contact':
            updateContact();
            break;
        case 'update_maps':
            updateMaps();
            break;
        case 'update_org_chart':
            updateOrgChart();
            break;
    }
}

function updateTextContent() {
    global $About;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $About->updateOne(
        ['type' => $type, 'title' => $title],
        ['$set' => ['description' => $description]],
        ['upsert' => true]
    );
    
    echo "<div class='alert success'>Content updated successfully!</div>";
}

function updateImageContent() {
    global $About;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $About->updateOne(
                ['type' => $type, 'title' => $title],
                ['$set' => ['img_path' => $targetPath]],
                ['upsert' => true]
            );
            echo "<div class='alert success'>Image updated successfully!</div>";
        } else {
            echo "<div class='alert error'>Failed to upload image!</div>";
        }
    }
}

function updateLogo() {
    global $Logo;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/logos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['logo']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)) {
            $Logo->updateOne(
                ['type' => $type, 'title' => $title],
                ['$set' => ['img_path' => $targetPath]],
                ['upsert' => true]
            );
            echo "<div class='alert success'>Logo updated successfully!</div>";
        } else {
            echo "<div class='alert error'>Failed to upload logo!</div>";
        }
    }
}

function updateContact() {
    global $Contact;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $Contact->updateOne(
        ['type' => $type, 'title' => $title],
        ['$set' => ['description' => $description]],
        ['upsert' => true]
    );
    
    echo "<div class='alert success'>Contact information updated successfully!</div>";
}

function updateMaps() {
    global $Contact;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    $iframe_link = $_POST['iframe_link'];
    
    $Contact->updateOne(
        ['type' => $type, 'title' => $title],
        ['$set' => ['iframe_link' => $iframe_link]],
        ['upsert' => true]
    );
    
    echo "<div class='alert success'>Map updated successfully!</div>";
}

function updateOrgChart() {
    global $OrgChart;
    
    $type = $_POST['type'];
    $title = $_POST['title'];
    
    if (isset($_FILES['org_chart']) && $_FILES['org_chart']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/org_charts/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES['org_chart']['name']);
        $targetPath = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['org_chart']['tmp_name'], $targetPath)) {
            $OrgChart->updateOne(
                ['type' => $type, 'title' => $title],
                ['$set' => ['img_path' => $targetPath]],
                ['upsert' => true]
            );
            echo "<div class='alert success'>Organizational chart updated successfully!</div>";
        } else {
            echo "<div class='alert error'>Failed to upload organizational chart!</div>";
        }
    }
}

// Fetch current content
$contentData = [
    'intro_hs' => $About->findOne(['type' => 'about', 'title' => 'intro_hs']),
    'background_hs' => $About->findOne(['type' => 'about', 'title' => 'background_hs']),
    'history_hs' => $About->findOne(['type' => 'about', 'title' => 'history_hs']),
    'vision' => $About->findOne(['type' => 'about', 'title' => 'vision']),
    'mission' => $About->findOne(['type' => 'about', 'title' => 'mission']),
    'core_values' => $About->findOne(['type' => 'about', 'title' => 'core_values']),
    'about-hs-img' => $About->findOne(['type' => 'about', 'title' => 'about-hs-img'])
];

$logoData = [
    'hs_logo' => $Logo->findOne(['type' => 'school_logo', 'title' => 'hs_logo'])
];

$contactData = [
    'district_hs' => $Contact->findOne(['type' => 'contact', 'title' => 'district_hs']),
    'city' => $Contact->findOne(['type' => 'contact', 'title' => 'city']),
    'hs_contactNo' => $Contact->findOne(['type' => 'contact', 'title' => 'hs_contactNo']),
    'hs_email' => $Contact->findOne(['type' => 'contact', 'title' => 'hs_email']),
    'hs_maps' => $Contact->findOne(['type' => 'maps', 'title' => 'hs_maps'])
];

$orgChartData = [
    'hs_org_chart' => $OrgChart->findOne(['type' => 'org_chart', 'title' => 'hs_org_chart'])
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SANHS - Content Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .section {
            background: white;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .section-header {
            background: #34495e;
            color: white;
            padding: 20px;
            font-size: 1.3em;
            font-weight: bold;
        }

        .section-content {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2c3e50;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea,
        .form-group input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        .form-group textarea {
            height: 120px;
            resize: vertical;
        }

        .form-group.large textarea {
            height: 200px;
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #27ae60;
        }

        .btn-success:hover {
            background: #229954;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .current-content {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #3498db;
            margin-bottom: 20px;
            border-radius: 0 5px 5px 0;
        }

        .current-content h4 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .current-image {
            max-width: 200px;
            max-height: 150px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .form-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .form-section h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .header h1 {
                font-size: 2em;
            }
            
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sta. Ana National High School</h1>
            <p>Content Management System</p>
        </div>

        <!-- About Section Content -->
        <div class="section">
            <div class="section-header">About Section Content</div>
            <div class="section-content">
                <div class="grid">
                    <!-- School Introduction -->
                    <div class="form-section">
                        <h3>School Introduction</h3>
                        <?php if ($contentData['intro_hs']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars(substr($contentData['intro_hs']['description'] ?? '', 0, 200)) ?>...</p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_text">
                            <input type="hidden" name="type" value="about">
                            <input type="hidden" name="title" value="intro_hs">
                            
                            <div class="form-group large">
                                <label>School Introduction Text:</label>
                                <textarea name="description" placeholder="Enter the school introduction text..."><?= htmlspecialchars($contentData['intro_hs']['description'] ?? '') ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update Introduction</button>
                        </form>
                    </div>

                    <!-- School Background -->
                    <div class="form-section">
                        <h3>School Background</h3>
                        <?php if ($contentData['background_hs']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars(substr($contentData['background_hs']['description'] ?? '', 0, 200)) ?>...</p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_text">
                            <input type="hidden" name="type" value="about">
                            <input type="hidden" name="title" value="background_hs">
                            
                            <div class="form-group large">
                                <label>School Background Text:</label>
                                <textarea name="description" placeholder="Enter the school background text..."><?= htmlspecialchars($contentData['background_hs']['description'] ?? '') ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update Background</button>
                        </form>
                    </div>

                    <!-- School History -->
                    <div class="form-section">
                        <h3>School History</h3>
                        <?php if ($contentData['history_hs']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars(substr($contentData['history_hs']['description'] ?? '', 0, 200)) ?>...</p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_text">
                            <input type="hidden" name="type" value="about">
                            <input type="hidden" name="title" value="history_hs">
                            
                            <div class="form-group large">
                                <label>School History Text:</label>
                                <textarea name="description" placeholder="Enter the school history text..."><?= htmlspecialchars($contentData['history_hs']['description'] ?? '') ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update History</button>
                        </form>
                    </div>

                    <!-- About Image -->
                    <div class="form-section">
                        <h3>About Section Image</h3>
                        <?php if ($contentData['about-hs-img'] && isset($contentData['about-hs-img']['img_path'])): ?>
                            <div class="current-content">
                                <h4>Current Image:</h4>
                                <img src="<?= htmlspecialchars($contentData['about-hs-img']['img_path']) ?>" class="current-image" alt="Current About Image">
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="update_image">
                            <input type="hidden" name="type" value="about">
                            <input type="hidden" name="title" value="about-hs-img">
                            
                            <div class="form-group">
                                <label>Upload New About Image:</label>
                                <input type="file" name="image" accept="image/*" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update Image</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision, Mission, Core Values -->
        <div class="section">
            <div class="section-header">Vision, Mission & Core Values Images</div>
            <div class="section-content">
                <div class="grid">
                    <?php 
                    $vmsItems = [
                        'vision' => 'Vision',
                        'mission' => 'Mission', 
                        'core_values' => 'Core Values'
                    ];
                    
                    foreach ($vmsItems as $key => $title): ?>
                        <div class="form-section">
                            <h3><?= $title ?></h3>
                            <?php if ($contentData[$key] && isset($contentData[$key]['img_path'])): ?>
                                <div class="current-content">
                                    <h4>Current Image:</h4>
                                    <img src="<?= htmlspecialchars($contentData[$key]['img_path']) ?>" class="current-image" alt="Current <?= $title ?> Image">
                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="update_image">
                                <input type="hidden" name="type" value="about">
                                <input type="hidden" name="title" value="<?= $key ?>">
                                
                                <div class="form-group">
                                    <label>Upload <?= $title ?> Image:</label>
                                    <input type="file" name="image" accept="image/*" required>
                                </div>
                                
                                <button type="submit" class="btn btn-success">Update <?= $title ?></button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Logo Management -->
        <div class="section">
            <div class="section-header">School Logo</div>
            <div class="section-content">
                <div class="form-section" style="max-width: 500px; margin: 0 auto;">
                    <h3>High School Logo</h3>
                    <?php if ($logoData['hs_logo'] && isset($logoData['hs_logo']['img_path'])): ?>
                        <div class="current-content">
                            <h4>Current Logo:</h4>
                            <img src="<?= htmlspecialchars($logoData['hs_logo']['img_path']) ?>" class="current-image" alt="Current Logo">
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_logo">
                        <input type="hidden" name="type" value="school_logo">
                        <input type="hidden" name="title" value="hs_logo">
                        
                        <div class="form-group">
                            <label>Upload New School Logo:</label>
                            <input type="file" name="logo" accept="image/*" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Logo</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Organizational Chart -->
        <div class="section">
            <div class="section-header">Organizational Chart</div>
            <div class="section-content">
                <div class="form-section" style="max-width: 800px; margin: 0 auto;">
                    <h3>High School Organizational Chart</h3>
                    <?php if ($orgChartData['hs_org_chart'] && isset($orgChartData['hs_org_chart']['img_path'])): ?>
                        <div class="current-content">
                            <h4>Current Organizational Chart:</h4>
                            <img src="<?= htmlspecialchars($orgChartData['hs_org_chart']['img_path']) ?>" 
                                 style="max-width: 100%; height: auto; border-radius: 5px; border: 1px solid #ddd;" 
                                 alt="Current Organizational Chart">
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="update_org_chart">
                        <input type="hidden" name="type" value="org_chart">
                        <input type="hidden" name="title" value="hs_org_chart">
                        
                        <div class="form-group">
                            <label>Upload New Organizational Chart:</label>
                            <input type="file" name="org_chart" accept="image/*" required>
                            <small style="color: #666; display: block; margin-top: 5px;">
                                Recommended: High resolution image (PNG or JPG) for better clarity when displayed on the website.
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Organizational Chart</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="section">
            <div class="section-header">Contact Information</div>
            <div class="section-content">
                <div class="grid">
                    <!-- District -->
                    <div class="form-section">
                        <h3>District Information</h3>
                        <?php if ($contactData['district_hs']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars($contactData['district_hs']['description'] ?? '') ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_contact">
                            <input type="hidden" name="type" value="contact">
                            <input type="hidden" name="title" value="district_hs">
                            
                            <div class="form-group">
                                <label>District:</label>
                                <input type="text" name="description" value="<?= htmlspecialchars($contactData['district_hs']['description'] ?? '') ?>" placeholder="Enter district information">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update District</button>
                        </form>
                    </div>

                    <!-- City -->
                    <div class="form-section">
                        <h3>City Information</h3>
                        <?php if ($contactData['city']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars($contactData['city']['description'] ?? '') ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_contact">
                            <input type="hidden" name="type" value="contact">
                            <input type="hidden" name="title" value="city">
                            
                            <div class="form-group">
                                <label>City:</label>
                                <input type="text" name="description" value="<?= htmlspecialchars($contactData['city']['description'] ?? '') ?>" placeholder="Enter city information">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update City</button>
                        </form>
                    </div>

                    <!-- Contact Number -->
                    <div class="form-section">
                        <h3>Contact Number</h3>
                        <?php if ($contactData['hs_contactNo']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars($contactData['hs_contactNo']['description'] ?? '') ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_contact">
                            <input type="hidden" name="type" value="contact">
                            <input type="hidden" name="title" value="hs_contactNo">
                            
                            <div class="form-group">
                                <label>Contact Number:</label>
                                <input type="text" name="description" value="<?= htmlspecialchars($contactData['hs_contactNo']['description'] ?? '') ?>" placeholder="Enter contact number">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update Contact Number</button>
                        </form>
                    </div>

                    <!-- Email -->
                    <div class="form-section">
                        <h3>Email Address</h3>
                        <?php if ($contactData['hs_email']): ?>
                            <div class="current-content">
                                <h4>Current Content:</h4>
                                <p><?= htmlspecialchars($contactData['hs_email']['description'] ?? '') ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <input type="hidden" name="action" value="update_contact">
                            <input type="hidden" name="type" value="contact">
                            <input type="hidden" name="title" value="hs_email">
                            
                            <div class="form-group">
                                <label>Email Address:</label>
                                <input type="email" name="description" value="<?= htmlspecialchars($contactData['hs_email']['description'] ?? '') ?>" placeholder="Enter email address">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Update Email</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maps -->
        <div class="section">
            <div class="section-header">Google Maps Integration</div>
            <div class="section-content">
                <div class="form-section" style="max-width: 800px; margin: 0 auto;">
                    <h3>School Location Map</h3>
                    <?php if ($contactData['hs_maps'] && isset($contactData['hs_maps']['iframe_link'])): ?>
                        <div class="current-content">
                            <h4>Current Map:</h4>
                            <iframe src="<?= htmlspecialchars($contactData['hs_maps']['iframe_link']) ?>" 
                                    width="100%" height="200" frameborder="0" allowfullscreen="" 
                                    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <input type="hidden" name="action" value="update_maps">
                        <input type="hidden" name="type" value="maps">
                        <input type="hidden" name="title" value="hs_maps">
                        
                        <div class="form-group">
                            <label>Google Maps Embed URL:</label>
                            <input type="text" name="iframe_link" value="<?= htmlspecialchars($contactData['hs_maps']['iframe_link'] ?? '') ?>" 
                                   placeholder="Enter Google Maps embed URL (starts with https://www.google.com/maps/embed...)">
                            <small style="color: #666; display: block; margin-top: 5px;">
                                To get the embed URL: Go to Google Maps → Search your location → Click "Share" → Click "Embed a map" → Copy the URL from the iframe src
                            </small>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Map</button>
                    </form>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin: 40px 0; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="color: #2c3e50; margin-bottom: 10px;">Website Management Complete</h3>
            <p style="color: #666;">All content sections have been configured. Changes will be reflected on your main website immediately.</p>
            <div style="margin-top: 15px;">
                <a href="about us hs.php" class="btn" style="text-decoration: none; display: inline-block; margin: 5px;">View About Us</a>
                <a href="org chart hs.php" class="btn" style="text-decoration: none; display: inline-block; margin: 5px;">View Org Chart</a>
            </div>
        </div>
    </div>
</body>
</html>