<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="elem">
        <!-- Header -->
        <header>
            <div class="logo-section">
                <?php
                    $elemLogo = $Logo->findOne([
                        'type' => 'school_logo',
                        'title' => 'elem_logo'
                    ]);

                    if ($elemLogo && isset($elemLogo['img_path'])) {
                        echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Image">';
                    }
                ?>

                <h1>STA. ANA CENTRAL ELEMENTARY SCHOOL</h1>
            </div>
        </header>

        <nav>
            <ul>
                <li><a href="welcome elem.php">Welcome</a></li>
                <li><a href="about us elem.php">About Us</a></li>
                <li><a href="org chart elem.php">Organizational Chart</a></li>
                <li><a href="">Programs Offered</a></li>
                <li><a href="">Admission</a></li>
                <li><a href="">Announcement</a></li>
                <li><a href="">FAQs</a></li>
                <li><a href="contact us elem.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="container-content">

                <br>

                <div class="contact-elem-title"><h1>Contact Us</h1></div>

                <div class="contact-us-info">
                    <div class="contacts-elem">
                        <div class="contact-elem-name"><h3>Sta. Ana Central Elementary School</h3></div>
                        
                        <?php
                            $titles = ['district_elem', 'city'];
                                    
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<h3>' . nl2br(htmlspecialchars($doc['description'])) . '</h3>';
                                }
                            }
                        ?>

                        <br>

                        <?php
                            $titles = ['elem_contactNo', 'elem_email'];
            
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                        echo '<h3>' . nl2br(htmlspecialchars($doc['description'])) . '</h3>';
                                }
                            }
                        ?>

                        <div class="elem-socials">
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
                                    $facebookElem = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'elem_facebook'
                                    ]);

                                    if ($facebookElem && isset($facebookElem['description'])) {
                                        $url = trim($facebookElem['description']);

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
                                    $youtubeElem = $Contact->findOne([
                                        'type' => 'contact',
                                        'title' => 'elem_youtube'
                                    ]);

                                    if ($youtubeElem && isset($youtubeElem['description'])) {
                                        $url = trim($youtubeElem['description']);

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
                            $elemMap = $Contact->findOne([
                                'type' => 'maps',
                                'title' => 'elem_maps'
                            ]);

                            if ($elemMap && isset($elemMap['iframe_link']) && !empty($elemMap['iframe_link'])) {
                                $iframeURL = htmlspecialchars($elemMap['iframe_link']);
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
                    <p>Copyright © 2025 Sta. Ana Central Elementary School. All Rights Reserved</p>
                </div>     
            </footer>
        </section>

    </body>
</html>