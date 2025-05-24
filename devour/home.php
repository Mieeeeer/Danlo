<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="home">
        <!-- Header -->
<header class="site-header">
    <h1 class="school-name">STA. ANA</h1>
    <div class="login">
        <a href="login.php" class="login-btn">Login</a>
    </div>
</header>

        <!-- Container -->
        <main class="container">
            <?php
                $elemImg = $Home->findOne(['type' => 'home', 'title' => 'home-elem-img']);
                $hsImg = $Home->findOne(['type' => 'home', 'title' => 'home-hs-img']);
                $elemLogo = $Logo->findOne(['type' => 'school_logo', 'title' => 'elem_logo']);
                $hsLogo = $Logo->findOne(['type' => 'school_logo', 'title' => 'hs_logo']);
            ?>

            <div class="school-container">
                <div class="school-panels">
                    <!-- Elementary Panel -->
                    <div class="school-panel" style="background-image: url('<?= $elemImg['img_path'] ?>');">
                        <img src="<?= $elemLogo['img_path'] ?>" alt="Elem Logo" class="school-logo-elem">
                        <div class="school-info">
                            <h3>STA. ANA<br>CENTRAL<br>ELEMENTARY</h3>
                            <a href="welcome elem.php" class="view-btn red">VIEW ELEMENTARY</a>
                        </div>
                    </div>

                    <!-- High School Panel -->
                    <div class="school-panel" style="background-image: url('<?= $hsImg['img_path'] ?>');">
                        <img src="<?= $hsLogo['img_path'] ?>" alt="HS Logo" class="school-logo-hs">
                        <div class="school-info">
                            <h3>STA. ANA<br>NATIONAL<br>HIGH SCHOOL</h3>
                            <a href="welcome hs.php" class="view-btn green">VIEW HIGH SCHOOL</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
                $aboutElem = $Home->findOne(['type' => 'home', 'title' => 'about-elem-home']);
                $aboutHS = $Home->findOne(['type' => 'home', 'title' => 'about-hs-home']);
            ?>

            <div class="about-section-home">
                <!-- Elementary About Card -->
                <div class="about-card-home red">
                    <h3>ABOUT THE ELEMENTARY SCHOOL</h3>
                    <p><?= $aboutElem['description'] ?></p>
                    <a href="about us elem.php" class="read-more">Read More →</a>
                </div>

                <!-- High School About Card -->
                <div class="about-card-home green">
                    <h3>ABOUT THE HIGH SCHOOL</h3>
                    <p><?= $aboutHS['description'] ?></p>
                    <a href="about us hs.php" class="read-more">Read More →</a>
                </div>
            </div>

            <div class="enrollment-stats-home">
                <h1>ENROLLMENT STATISTICS</h1>
                    <?php
                        $dataMap = [];
                        $cursor = $Enrollment->find(['type' => 'enrollment_data']);
                        
                        foreach ($cursor as $doc) {
                            $dataMap[$doc['title']] = $doc;
                        }

                        $femaleIcon = $dataMap['female_icon']['img_path'] ?? '';
                        $maleIcon = $dataMap['male_icon']['img_path'] ?? '';
                        $femalePercentElem = $dataMap['elem_female_percent']['data'] ?? '0%';
                        $malePercentElem = $dataMap['elem_male_percent']['data'] ?? '0%';
                        $femalePercentHs = $dataMap['hs_female_percent']['data'] ?? '0%';
                        $malePercentHs = $dataMap['hs_male_percent']['data'] ?? '0%';
                    ?>
                
                <div class="stats-data-home">
                    <div class="elem-stats">
                        <h3>ELEMENTARY</h3>

                        <div class="enrollment-icons">
                            <div class="female-block">
                                <img src="<?= htmlspecialchars($femaleIcon) ?>" alt="Female">
                            </div>

                            <div class="percentage">
                                <p class="female-percent"><?= htmlspecialchars($femalePercentElem) ?></p>
                                <p class="male-percent"><?= htmlspecialchars($malePercentElem) ?></p>
                            </div>
                                
                            <div class="male-block">
                                <img src="<?= htmlspecialchars($maleIcon) ?>" alt="Male">
                            </div>
                        </div>
                    </div>

                    <div class="hs-stats">
                        <h3>HIGH SCHOOL</h3>

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
            </div>

            <div class="latest-updates">
                <h1>LATEST UPDATES</h1>

                <?php
                    $filter = ['type' => 'announcement'];
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

            <div class="home-footer">
              <div class="home-footer-container">
                
                <div class="home-contacts-elem">
                    <?php
                        $titles = ['elem_school_name', 'district_elem', 'city', 'elem_email'];
                              
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                    ?>
                </div>

                <div class="home-maps">
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

                <div class="home-contacts-hs">
                    <?php
                        $titles = ['hs_school_name', 'district_hs', 'city', 'hs_email'];
                              
                            foreach ($titles as $title) {
                                $doc = $Contact->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                    ?>
                </div>

                <div class="home-maps">
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

            <div class="logos">
                <?php
                    $titles = ['deped_logo', 'elem_logo', 'city', 'hs_logo'];
                              
                    foreach ($titles as $title) {
                        $doc = $Logo->findOne(['type' => 'school_logo', 'title' => $title]);

                        if ($doc && isset($doc['img_path'])) {
                            echo '<img src="' . htmlspecialchars($doc['img_path']) . '" alt="Image">';
                        }
                    }
                ?>
            </div>
            
            <div class="home-copyright">
                <p>Copyright © 2025 Sta. Ana Central Elementary School & Sta. Ana National High School</p>
            </div>
            
        </footer>

    </body>
</html>