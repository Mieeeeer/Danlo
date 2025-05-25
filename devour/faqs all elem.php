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
                <li><a href="">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <section class="faqs-section">
                <br>
                
                <h2>FREQUENTLY ASKED QUESTIONS</h2>

                    <header class="top-nav">
                        <nav>
                            <ul>
                                <li><a href="faqs elem.php" class="active">Home</a></li>
                                <li><a href="faqs ask question.php">Ask a Question</a></li>
                            </ul>
                        </nav>
                        <div class="info-bar">
                        <?php
                                $FAQsDescription = $FAQs->findOne([
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

                    <a class="home-btn" href="faqs elem.php">Home</a>

                    <?php
                        $FAQsQnA_IMG = $FAQs->findOne([
                            'type' => 'faqs',
                            'title' => 'faqs-qna-img'
                        ]);

                        if ($FAQsQnA_IMG && isset($FAQsQnA_IMG['img_path'])) {
                            echo '<div class="qna-heading">';
                            echo '<img src="' . htmlspecialchars($FAQsQnA_IMG['img_path']) . '" alt="Image">';
                            echo '<p>Most Popular Questions</p>';
                            echo '</div>';
                        }
                    ?>

                    <ul class="faq-list">
                        <?php
                            $allFaqs = $FAQs->find(
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
                                echo '<a href="faqs view elem.php?id=' . urlencode($faq['_id']) . '" style="text-decoration: none; color: inherit;">';
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