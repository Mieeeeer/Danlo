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
            <div class="welcome">
                <nav>
                    <ul>
                        <li><a href="home.php">Home</a></li>
                        <li><a href="about us hs.php">About Us</a></li>
                        <li><a href="org chart hs.php">Organizational Chart</a></li>
                        <li><a href="">Programs Offered</a></li>
                        <li><a href="">Admission</a></li>
                        <li><a href="">Announcement</a></li>
                        <li><a href="">FAQs</a></li>
                        <li><a href="">Contact Us</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Container -->
        <main class="container">
            <h1>Highschool Welcome Page Here</h1>
            <br><br>
        </main>

        <!-- Footer -->
        <footer>
            <div class="footer-info">
                <div class="contact">
                
                    <div class="logo-section-footer">
                        <?php
                            $hsLogo = $Content->findOne([
                                'type' => 'school_logo',
                                'title' => 'hs_logo'
                            ]);

                            if ($hsLogo && isset($hsLogo['img_path'])) {
                                echo '<img src="' . htmlspecialchars($hsLogo['img_path']) . '" alt="Image">';
                            }
                        ?>

                    <h1>STA. ANA NATIONAL<br>HIGH SCHOOL</h1>
                    </div>

                    <br><br>
            
                    <div class="contact-info">
                        <?php
                            $titles = ['district_hs', 'city'];
      
                            foreach ($titles as $title) {
                                $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                        ?>
                
                        <br>

                        <?php
                            $titles = ['hs_contactNo', 'hs_email'];
      
                            foreach ($titles as $title) {
                                $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                        ?>
                    </div>
                </div>

                <div class="copyright">
                    <p>Copyright © 2025 Sta. Ana National High School. All Rights Reserved</p>
                </div>

                <div class="maps">
                    <?php
                        $hsMap = $Content->findOne([
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
        </footer>

    </body>
</html>