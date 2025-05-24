<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="hs">
        <!-- Header -->
        <header>
            <div class="logo-section">
                <?php
                    $hsLogo = $Logo->findOne([
                        'type' => 'school_logo',
                        'title' => 'hs_logo'
                    ]);

                    if ($hsLogo && isset($hsLogo['img_path'])) {
                        echo '<img src="' . htmlspecialchars($hsLogo['img_path']) . '" alt="Image">';
                    }
                ?>

                <h1>STA. ANA NATIONAL HIGH SCHOOL</h1>
            </div>
        </header>

        <nav>
            <ul>
                <li><a href="welcome hs.php">Welcome</a></li>
                <li><a href="about us hs.php">About Us</a></li>
                <li><a href="org chart hs.php">Organizational Chart</a></li>
                <li><a href="">Programs Offered</a></li>
                <li><a href="">Admission</a></li>
                <li><a href="">Announcement</a></li>
                <li><a href="">FAQs</a></li>
                <li><a href="contact us hs.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="container-content">

                <br>

                <div class="contact-hs-title"><h1>Contact Us</h1></div>

                <div class="contact-us-info">
                    <div class="contacts-hs">
                        <div class="contact-hs-name"><h3>Sta. Ana National High School</h3></div>
                        
                        <?php
                            $titles = ['district_hs', 'city'];
                                    
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<h3>' . nl2br(htmlspecialchars($doc['description'])) . '</h3>';
                                }
                            }
                        ?>

                        <br>

                        <?php
                            $titles = ['hs_contactNo', 'hs_email'];
            
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                        echo '<h3>' . nl2br(htmlspecialchars($doc['description'])) . '</h3>';
                                }
                            }
                        ?>

                        <div class="hs-socials">
                            <div class="facebook">
                                <?php
                                    $facebookIcon = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'facebook-icon'
                                    ]);

                                    if ($facebookIcon && isset($facebookIcon['img_path'])) {
                                        echo '<img src="' . htmlspecialchars($facebookIcon['img_path']) . '" alt="Image">';
                                    }
                                ?>

                                <?php
                                    $facebookHs = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'hs_facebook'
                                    ]);

                                    if ($facebookHs && isset($facebookHs['description'])) {
                                        $url = trim($facebookHs['description']);

                                        if (!preg_match('/^https?:\/\//i', $url)) {
                                            $url = 'https://' . $url;
                                        }

                                        echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($url) . '</a>';
                                    } 
                                ?>
                            </div>

                            <div class="youtube">
                                <?php
                                    $youtubeIcon = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'youtube-icon'
                                    ]);

                                    if ($youtubeIcon && isset($youtubeIcon['img_path'])) {
                                        echo '<img src="' . htmlspecialchars($youtubeIcon['img_path']) . '" alt="Image">';
                                    }
                                ?>

                                <?php
                                    $youtubeHs = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'hs_youtube'
                                    ]);

                                    if ($youtubeHs && isset($youtubeHs['description'])) {
                                        $url = trim($youtubeHs['description']);

                                        if (!preg_match('/^https?:\/\//i', $url)) {
                                            $url = 'https://' . $url;
                                        }

                                        echo '<a href="' . htmlspecialchars($url) . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($url) . '</a>';
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="contacts-maps">
                        <?php
                            $hsMap = $Contact->findOne([
                                'type' => 'maps',
                                'title' => 'hs_maps'
                            ]);

                            if ($hsMap && isset($hsMap['iframe_link']) && !empty($hsMap['iframe_link'])) {
                                $iframeURL = htmlspecialchars($hsMap['iframe_link']);
                                echo '<iframe src="' . $iframeURL . '" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                            } else {
                                echo '<p>Map not available.</p>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <section class="contact-footer">
            <footer>
                <div class="copyright-contact">
                    <p>Copyright © 2025 Sta. Ana National High School. All Rights Reserved</p>
                </div>     
            </footer>
        </section>

    </body>
</html>