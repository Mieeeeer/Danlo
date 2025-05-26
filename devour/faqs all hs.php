<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana National High School - FAQs/View All</title>
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
                <li><a href="programs offered hs.php">Programs Offered</a></li>
                <li><a href="admission hs.php">Admission</a></li>
                <li><a href="announcement hs.php">Announcement</a></li>
                <li><a href="faqs hs.php">FAQs</a></li>
                <li><a href="contact us hs.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <section class="faqs-section-hs">
                <br>
                
                <h2>FREQUENTLY ASKED QUESTIONS</h2>

                    <header class="top-nav">
                        <nav>
                            <ul>
                                <li><a href="faqs hs.php" class="active">Home</a></li>
                                <li><a href="faqs ask question hs.php">Ask a Question</a></li>
                            </ul>
                        </nav>
                        <div class="info-bar">
                        <?php
                                $FAQsDescription = $FAQs_HS->findOne([
                                    'type' => 'faqs',
                                    'title' => 'faqs-description'
                                ]);

                                if ($FAQsDescription && isset($FAQsDescription['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($FAQsDescription['description'])) . '</h2>';
                                }
                            ?>
                        </div>
                    </header>

                    <div class="divider"></div>

                <div class="most-popular-quest">

                    <a class="home-btn" href="faqs hs.php">Home</a>

                    <?php
                        $FAQsQnA_IMG = $FAQs_HS->findOne([
                            'type' => 'faqs',
                            'title' => 'faqs-qna-img'
                        ]);

                        if ($FAQsQnA_IMG && isset($FAQsQnA_IMG['img_path'])) {
                            echo '<div class="qna-heading">';
                            echo '<img src="' . htmlspecialchars($FAQsQnA_IMG['img_path']) . '" alt="Image">';
                            echo '<p>Published answers</p>';
                            echo '</div>';
                        }
                    ?>

                    <ul class="faq-list">
                        <?php
                            $allFaqs = $FAQs_HS->find(
                                ['published' => true],
                                ['sort' => ['question' => 1]]
                            );

                            foreach ($allFaqs as $faq) {
                                $question = htmlspecialchars($faq['question']);
                                $answer = strip_tags($faq['answer']);
                                $maxLength = 300;

                                if (strlen($answer) > $maxLength) {
                                    $truncated = substr($answer, 0, strrpos(substr($answer, 0, $maxLength), ' ')) . '...';
                                } else {
                                    $truncated = $answer;
                                }

                                echo '<li>';
                                echo '<a href="faqs view hs.php?id=' . urlencode($faq['_id']) . '" style="text-decoration: none; color: inherit;">';
                                echo '<strong>' . $question . '</strong>';
                                echo '<p style="font-weight: normal;">' . htmlspecialchars($truncated) . '</p>';
                                echo '</a>';
                                echo '</li>';
                            }
                        ?>
                    </ul>
                </div>
            </section>
            <br>
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