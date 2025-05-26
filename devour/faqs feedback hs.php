<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sta. Ana National High School - FAQs/Feedback</title>
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

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="welcome hs.php">Welcome</a></li>
            <li><a href="about us hs.php">About Us</a></li>
            <li><a href="org chart hs.php">Organizational Chart</a></li>
            <li><a href="programs hs.php">Programs Offered</a></li>
            <li><a href="admission hs.php">Admission</a></li>
            <li><a href="announcement hs.php">Announcement</a></li>
            <li><a href="faqs hs.php">FAQs</a></li>
            <li><a href="contact us hs.php">Contact Us</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <section class="faqs-section-hs">
            <br>
            <h2>FREQUENTLY ASKED QUESTION</h2>

                <header class="top-nav">
                        <nav>
                            <ul>
                                <li><a href="faqs hs.php">Home</a></li>
                                <li><a href="faqs ask question hs.php">Ask a Question</a></li>
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
                    
                    <p class="feedback-submitted">Your feedback has been submitted!</p>

                        <div class="feedback-message">
                            <?php
                                $feedback = $_GET['feedback'] ?? '';

                                echo '<p class="thankyou-msg">Thank you for your feedback. We value responses from our users.</p>';

                                if ($feedback === 'yes') {
                                    echo '<p class="result-msg">We are glad this answered your question.</p>';
                                } elseif ($feedback === 'no') {
                                    echo '<p class="result-msg">Sorry this didn’t help. We are working on improving our answers.</p>';
                                } else {
                                    echo '<p>Invalid feedback response.</p>';
                                }
                            ?>
                        </div>

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
                                echo '<img src="' . htmlspecialchars(string: $hsLogo['img_path']) . '" alt="Image">';
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
