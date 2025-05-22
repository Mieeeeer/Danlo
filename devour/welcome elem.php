<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="elem">
        <div class="elem-welcome">
            <header>
                <section class="welcome">
                    <nav>
                        <ul class="navbar">
                            <li><a href="home.php">Home</a></li>
                            <li><a href="about us elem.php">About Us</a></li>
                            <li><a href="org chart elem.php">Organizational Chart</a></li>
                            <li><a href="">Programs Offered</a></li>
                            <li><a href="">Admission</a></li>
                            <li><a href="">Announcement</a></li>
                            <li><a href="">FAQs</a></li>
                            <li><a href="">Contact Us</a></li>
                        </ul>
                    </nav>
                </section>
                
            </header>
        </div>
        
        <!-- Container -->
        <main class="welcome-container">
            
            <div class="school-img">
                <?php
                    $welcomeElemImage = $Content->findOne([
                        'type' => 'welcome',
                        'title' => 'welcome_img_elem'
                        ]);

                    if ($welcomeElemImage && isset($welcomeElemImage['img_path'])) {
                        echo '<img src="' . htmlspecialchars($welcomeElemImage['img_path']) . '" alt="Image">';
                    }
                ?>
            </div>

            <section class="hero">
                <?php
                    $elemLogo = $Content->findOne([
                        'type' => 'school_logo',
                        'title' => 'elem_logo'
                    ]);

                    if ($elemLogo && isset($elemLogo['img_path'])) {
                        echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Image">';
                    }
                ?>

                <h1 class="welcome">WELCOME TO</h1>
                <h1 class="sta-ana">STA. ANA CENTRAL<br>ELEMENTARY SCHOOL</h1>
            </section>

            <section class="about">
                <div class="about-text">
                    <h2 class="about-text-elem"><u>ABOUT THE SCHOOL</u></h2>

                    <?php
                        $aboutElemWelcome = $Content->findOne([
                            'type' => 'welcome',
                            'title' => 'about_elem_welcome'
                        ]);

                        if ($aboutElemWelcome && isset($aboutElemWelcome['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($aboutElemWelcome['description'])) . '</p>';
                        } 
                    ?>

                    <a class="see-more" href="about us elem.php">See More →</a>
                </div>

                <div class="about-video">
                    <?php
                        $ytEmbed = $Content->findOne([
                            'type' => 'welcome',
                            'title' => 'elem_yt_link'
                        ]);

                        if ($ytEmbed && isset($ytEmbed['iframe_link'])) {
                            echo '<div class="youtube-wrapper">';
                            echo '<iframe width="560" height="315" src="' . htmlspecialchars($ytEmbed['iframe_link']) . '" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </section>

            <section class="enrollment">
                <?php
                    $enrollmentData = $Content->findOne([
                        'type' => 'enrollment_data',
                        'title' => 'elem_school_year'
                    ]);

                    if ($enrollmentData && isset($enrollmentData['description'])) {
                        echo '<h2>' . nl2br(htmlspecialchars($enrollmentData['description'])) . '</h2>';
                    } 
                ?>

                <div class="enrollment-stats">
                    <?php
                        $dataMap = [];
                        $cursor = $Content->find(['type' => 'enrollment_data']);
                        
                        foreach ($cursor as $doc) {
                            $dataMap[$doc['title']] = $doc;
                        }

                        $femaleIcon = $dataMap['female_icon']['img_path'] ?? '';
                        $maleIcon = $dataMap['male_icon']['img_path'] ?? '';
                        $femaleCount = $dataMap['elem_female_enrollee']['data'] ?? '0';
                        $maleCount = $dataMap['elem_male_enrollee']['data'] ?? '0';
                        $total = $dataMap['elem_total_enrollee']['data'] ?? '0';
                        $femalePercent = $dataMap['elem_female_percent']['data'] ?? '0%';
                        $malePercent = $dataMap['elem_male_percent']['data'] ?? '0%';
                    ?>

                    <div class="enrollment-stats">
                        <div class="enrollment-legend">
                            <p><span class="dot female"></span> <?= number_format($femaleCount) ?> Female Students</p>
                            <p><span class="dot male"></span> <?= number_format($maleCount) ?> Male Students</p>
                            <p><strong><?= number_format($total) ?> TOTAL ENROLLED</strong></p>
                        </div>
                        <div class="enrollment-icons">
                            <div class="female-block">
                                <img src="<?= htmlspecialchars($femaleIcon) ?>" alt="Female">
                                <p class="female-percent"><?= htmlspecialchars($femalePercent) ?></p>
                            </div>
                            <div class="male-block">
                                <img src="<?= htmlspecialchars($maleIcon) ?>" alt="Male">
                                <p class="male-percent"><?= htmlspecialchars($malePercent) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer>
            <div class="footer-info">
                <div class="contact">
                
                    <div class="logo-section-footer">
                        <?php
                            $elemLogo = $Content->findOne([
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
                                $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                        ?>
                
                        <br>

                        <?php
                            $titles = ['elem_contactNo', 'elem_email'];
      
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
                    <p>Copyright © 2025 Sta. Ana Central Elementary School. All Rights Reserved</p>
                </div>

                <div class="maps">
                    <?php
                        $elemMap = $Content->findOne([
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