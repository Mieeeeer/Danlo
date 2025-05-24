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
                    $elemLogo = $Content->findOne([
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
                <li><a href="">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <section class="faqs-section">
                <h2>Frequently Asked Questions</h2>

                <?php
                    $popularFaqs = $FAQs->find(
                        ['published' => true],
                        [
                            'sort' => ['views' => -1],
                            'limit' => 5
                        ]
                    );

                    echo '<h3>Most Popular Questions</h3>';
                    echo '<ul class="faq-list">';
                    foreach ($popularFaqs as $faq) {
                        $question = htmlspecialchars($faq['question']);
                        $answer = strip_tags($faq['answer']);
                        $maxLength = 200;

                        // Truncate answer
                        if (strlen($answer) > $maxLength) {
                            $truncated = substr($answer, 0, $maxLength);
                            $lastSpace = strrpos($truncated, ' ');
                            if ($lastSpace !== false) {
                                $truncated = substr($truncated, 0, $lastSpace);
                            }
                            $truncated .= '...';
                        } else {
                            $truncated = $answer;
                        }

                        // Display clickable FAQ
                        echo '<li>';
                        echo '<a href="faq_view.php?id=' . urlencode($faq['_id']) . '" style="text-decoration: none; color: inherit;">';
                        echo '<strong>' . $question . '</strong>';
                        echo '<p>' . htmlspecialchars($truncated) . '</p>';
                        echo '</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                ?>

                <a class="show-more-btn" href="faqs all elem.php">Show More Published Answers</a>
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