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
                    // Get latest content items marked for high school display
                    $filter = [
                        '$and' => [
                            ['type' => ['$in' => ['news', 'blog_post', 'facebook_post']]],
                            ['status' => 'published'],
                            ['display_pages' => 'highschool']
                        ]
                    ];
                    $options = [
                        'sort' => ['created_at' => -1],
                        'limit' => 3
                    ];

                    $latest_content = $Content->find($filter, $options);                    
                ?>

                <section class="announcement-section">
                    <div class="announcement-cards">
                        <?php foreach ($latest_content as $content): ?>
                        <div class="announcement-card">
                            <?php if ($content['type'] === 'facebook_post'): ?>
                                <div class="iframe-wrapper">
                                    <iframe 
                                        src="https://www.facebook.com/plugins/post.php?href=<?php echo urlencode($content['post_url']); ?>&show_text=true&width=500" 
                                        width="500" 
                                        height="600" 
                                        style="border:none;overflow:hidden" 
                                        scrolling="no" 
                                        frameborder="0" 
                                        allowfullscreen="true" 
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                    </iframe>
                                </div>
                            <?php else: ?>
                                <div class="content-card">
                                    <?php if (isset($content['featured_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($content['featured_image']); ?>" alt="Featured Image" class="content-image">
                                    <?php endif; ?>
                                    <div class="content-details">
                                        <h3><?php echo htmlspecialchars($content['title']); ?></h3>
                                        <?php if ($content['type'] === 'blog_post'): ?>
                                            <p class="excerpt"><?php echo htmlspecialchars($content['excerpt']); ?></p>
                                        <?php endif; ?>
                                        <div class="meta">
                                            <span class="type"><?php echo ucfirst(str_replace('_', ' ', $content['type'])); ?></span>
                                            <span class="author">By <?php echo htmlspecialchars($content['author']); ?></span>
                                            <span class="date"><?php echo $content['created_at']->toDateTime()->format('M j, Y'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <style>
                    .content-card {
                        background: white;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        overflow: hidden;
                        margin-bottom: 20px;
                    }

                    .content-image {
                        width: 100%;
                        height: 200px;
                        object-fit: cover;
                    }

                    .content-details {
                        padding: 15px;
                    }

                    .content-details h3 {
                        margin: 0 0 10px 0;
                        color: #333;
                        font-size: 1.2rem;
                    }

                    .excerpt {
                        color: #666;
                        margin: 10px 0;
                        font-size: 0.9rem;
                        line-height: 1.4;
                    }

                    .meta {
                        font-size: 0.8rem;
                        color: #666;
                        display: flex;
                        gap: 10px;
                        flex-wrap: wrap;
                    }

                    .type {
                        color: #8c0000;
                        font-weight: bold;
                    }
                </style>
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