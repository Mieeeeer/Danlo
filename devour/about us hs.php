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
                <li><a href="announcement hs.php">Announcement</a></li>
                <li><a href="faqs hs.php">FAQs</a></li>
                <li><a href="contact us hs.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="container-content">
                <section class="hs-intro">
                    <br>
                    <h2>Sta. Ana National High School</h2>

                    <?php
                        $introHs = $About->findOne([
                            'type' => 'about',
                            'title' => 'intro_hs'
                        ]);

                        if ($introHs && isset($introHs['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($introHs['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="hs-about-img">
                    <?php
                        $aboutHsImage = $About->findOne([
                            'type' => 'about',
                            'title' => 'about-hs-img'
                        ]);

                        if ($aboutHsImage && isset($aboutHsImage['img_path'])) {
                            echo '<img src="' . htmlspecialchars($aboutHsImage['img_path']) . '" alt="Image">';
                        }
                    ?>
                </section>

                <section class="hs-background">
                    <?php
                        $backgroundHs = $About->findOne([
                            'type' => 'about',
                            'title' => 'background_hs'
                        ]);

                        if ($backgroundHs && isset($backgroundHs['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($backgroundHs['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="hs-history">
                    <div class="hs-history-title">
                        <h3>History of SANHS</h3>
                    </div>

                    <?php
                        $historyHs = $About->findOne([
                            'type' => 'about',
                            'title' => 'history_hs'
                        ]);

                        if ($historyHs && isset($historyHs['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($historyHs['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="hs-vms">
                    <div class="hs-vms-title">
                        <h3>Mission, Vision & Core Values</h3>    
                    </div>
                    
                    <div class="vms-section">
                        <?php
                            $titles = ['vision', 'mission', 'core_values'];
            
                            foreach ($titles as $title) {
                                $doc = $About->findOne(['type' => 'about', 'title' => $title]);

                                if ($doc && isset($doc['img_path'])) {
                                    echo '<div class="about-card">';
                                    echo '<img src="' . htmlspecialchars($doc['img_path']) . '" alt="' . ucfirst($title) . '" class="cards' . htmlspecialchars($title) . '">';
                                    echo '</div>';
                                }
                            }
                        ?>
                    </div>
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="footer-info">
                <div class="contact">
                
                    <div class="logo-section-footer">
                        <?php
                            $hsLogo = $Logo->findOne([
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
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                        ?>
                
                        <br>

                        <?php
                            $titles = ['hs_contactNo', 'hs_email'];
      
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

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
        </footer>

    </body>
</html>