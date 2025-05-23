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
                <section class="elem-intro">
                    <br>
                    <h2>Sta. Ana Central Elementary School</h2>

                    <?php
                        $introElem = $About->findOne([
                            'type' => 'about',
                            'title' => 'intro_elem'
                        ]);

                        if ($introElem && isset($introElem['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($introElem['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="elem-about-img">
                    <?php
                        $aboutElemImage = $About->findOne([
                            'type' => 'about',
                            'title' => 'about-elem-img'
                        ]);

                        if ($aboutElemImage && isset($aboutElemImage['img_path'])) {
                            echo '<img src="' . htmlspecialchars($aboutElemImage['img_path']) . '" alt="Image">';
                        }
                    ?>
                </section>

                <section class="elem-background">
                    <?php
                        $backgroundElem = $About->findOne([
                            'type' => 'about',
                            'title' => 'background_elem'
                        ]);

                        if ($backgroundElem && isset($backgroundElem['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($backgroundElem['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="elem-history">
                    <div class="elem-history-title">
                        <h3>History of SACES</h3>
                    </div>

                    <?php
                        $historyElem = $About->findOne([
                            'type' => 'about',
                            'title' => 'history_elem'
                        ]);

                        if ($historyElem && isset($historyElem['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($historyElem['description'])) . '</p>';
                        } 
                    ?>
                </section>

                <section class="elem-vms">
                    <div class="elem-vms-title">
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
                            $elemLogo = $Logo->findOne([
                                'type' => 'school_logo',
                                'title' => 'elem_logo'
                            ]);

                            if ($elemLogo && isset($elemLogo['img_path'])) {
                                echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Image">';
                            }
                        ?>

                    <h1>STA. ANA CENTRAL<br>ELEMENTARY SCHOOL</h1>
                    </div>

                    <br><br>
            
                    <div class="contact-info">
                        <?php
                            $titles = ['district_elem', 'city'];
      
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                        ?>
                
                        <br>

                        <?php
                            $titles = ['elem_contactNo', 'elem_email'];
      
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
                    <p>Copyright © 2025 Sta. Ana Central Elementary School. All Rights Reserved</p>
                </div>

                <div class="maps">
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
        </footer>

    </body>
</html>