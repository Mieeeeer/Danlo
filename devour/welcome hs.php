<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="hs">
        <div class="hs-welcome">
            <header>
                <section class="welcome">
                    <nav>
                        <ul class="navbar">
                            <li><a href="home.php">Home</a></li>
                            <li><a href="about us hs.php">About Us</a></li>
                            <li><a href="org chart hs.php">Organizational Chart</a></li>
                            <li><a href="">Programs Offered</a></li>
                            <li><a href="">Admission</a></li>
                            <li><a href="">Announcement</a></li>
                            <li><a href="">FAQs</a></li>
                            <li><a href="contact us hs.php">Contact Us</a></li>
                        </ul>
                    </nav>
                </section>
                
            </header>
        </div>
        
        <!-- Container -->
        <main class="welcome-container">
            
            <div class="school-img">
                <?php
                    $welcomeHsImage = $Welcome->findOne([
                        'type' => 'welcome',
                        'title' => 'welcome_img_hs'
                        ]);

                    if ($welcomeHsImage && isset($welcomeHsImage['img_path'])) {
                        echo '<img src="' . htmlspecialchars($welcomeHsImage['img_path']) . '" alt="Image">';
                    }
                ?>
            </div>

            <section class="hero">
                <?php
                    $hsLogo = $Logo->findOne([
                        'type' => 'school_logo',
                        'title' => 'hs_logo'
                    ]);

                    if ($hsLogo && isset($hsLogo['img_path'])) {
                        echo '<img src="' . htmlspecialchars($hsLogo['img_path']) . '" alt="Image">';
                    }
                ?>

                <h1 class="welcome">WELCOME TO</h1>
                <h1 class="sta-ana">STA. ANA NATIONAL<br>HIGH SCHOOL</h1>
            </section>

            <section class="about">
                <div class="about-text">
                    <h2 class="about-text-hs"><u>ABOUT THE SCHOOL</u></h2>

                    <?php
                        $aboutHsWelcome = $Welcome->findOne([
                            'type' => 'welcome',
                            'title' => 'about_hs_welcome'
                        ]);

                        if ($aboutHsWelcome && isset($aboutHsWelcome['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($aboutHsWelcome['description'])) . '</p>';
                        } 
                    ?>

                    <div class="see-more-hs">
                        <a class="see-more" href="about us hs.php">See More →</a>
                    </div>
                </div>

                <div class="about-video">
                    <?php
                        $ytEmbed = $Welcome->findOne([
                            'type' => 'welcome',
                            'title' => 'hs_yt_link'
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
                    $enrollmentData = $Enrollment->findOne([
                        'type' => 'enrollment_data',
                        'title' => 'hs_school_year'
                    ]);

                    if ($enrollmentData && isset($enrollmentData['description'])) {
                        echo '<h2>' . nl2br(htmlspecialchars($enrollmentData['description'])) . '</h2>';
                    } 
                ?>

                <div class="enrollment-stats">
                    <?php
                        $dataMap = [];
                        $cursor = $Enrollment->find(['type' => 'enrollment_data']);
                        
                        foreach ($cursor as $doc) {
                            $dataMap[$doc['title']] = $doc;
                        }

                        $femaleIcon = $dataMap['female_icon']['img_path'] ?? '';
                        $maleIcon = $dataMap['male_icon']['img_path'] ?? '';
                        $femaleCountHs = $dataMap['hs_female_enrollee']['data'] ?? '0';
                        $maleCountHs = $dataMap['hs_male_enrollee']['data'] ?? '0';
                        $totalHs = $dataMap['hs_total_enrollee']['data'] ?? '0';
                        $femalePercentHs = $dataMap['hs_female_percent']['data'] ?? '0%';
                        $malePercentHs = $dataMap['hs_male_percent']['data'] ?? '0%';
                    ?>

                    <div class="enrollment-stats">
                        <div class="enrollment-legend">
                            <p><span class="dot female"></span> <?= number_format($femaleCountHs) ?> Female Students</p>
                            <p><span class="dot male"></span> <?= number_format($maleCountHs) ?> Male Students</p>
                            <p><strong><?= number_format($totalHs) ?> TOTAL ENROLLED</strong></p>
                        </div>
                        <div class="enrollment-icons">
                            <div class="female-block">
                                <img src="<?= htmlspecialchars($femaleIcon) ?>" alt="Female">
                            </div>

                            <div class="percentage">
                                <p class="female-percent"><?= htmlspecialchars($femalePercentHs) ?></p>
                                <p class="male-percent"><?= htmlspecialchars($malePercentHs) ?></p>
                            </div>

                            <div class="male-block">
                                <img src="<?= htmlspecialchars($maleIcon) ?>" alt="Male">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="latest-announcement">
                <h1 class="announcement-hs">LATEST ANNOUNCEMENTS</h1>
            </section>

            <div class="latest-updates">

                <?php
                    $filter = [
                        'type' => 'announcement',
                        'school_level' => 'highschool'
                    ];
                    $options = [
                        'sort' => ['created_at' => -1],
                        'limit' => 3
                    ];

                    $announcements = $AnnouncementLink->find($filter, $options);                    
                ?>

                <section class="announcement-section">
                    <div class="announcement-cards">
                        <?php foreach ($announcements as $announcement): ?>
                        <div class="announcement-card">
                            <div class="iframe-wrapper">
                                <iframe 
                                    src="<?= htmlspecialchars($announcement['iframe_link']) ?>" 
                                    width="500" 
                                    height="600" 
                                    style="border:none;overflow:hidden" 
                                    scrolling="no" 
                                    frameborder="0" 
                                    allowfullscreen="true" 
                                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                </iframe>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
            <br>
        </main>

        <!-- Footer -->
        <footer>
            <div class="footer-info">
                <div class="contact">
                
                    <div class="logo-section-footer">
                        <?php
                            $hsImg = $Logo->findOne([
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