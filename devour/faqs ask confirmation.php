<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sta. Ana School - FAQ</title>
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

    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="welcome elem.php">Welcome</a></li>
            <li><a href="about us elem.php">About Us</a></li>
            <li><a href="org chart elem.php">Organizational Chart</a></li>
            <li><a href="programs offered elem.php">Programs Offered</a></li>
            <li><a href="admission elem.php">Admission</a></li>
            <li><a href="announcement elem.php">Announcement</a></li>
            <li><a href="faqs elem.php">FAQs</a></li>
            <li><a href="contact us elem.php">Contact Us</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <section class="faqs-section">
            <br>
            
            <h2>FREQUENTLY ASKED QUESTIONS</h2>

                <header class="top-nav">
                        <nav>
                            <ul>
                                <li><a href="faqs elem.php">Home</a></li>
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
                    
                    <p class="feedback-submitted">Your question has been submitted!</p>

                        <div class="feedback-message">

                            <?php
                                $referenceId = isset($_GET['ref']) ? htmlspecialchars($_GET['ref']) : 'Unavailable';
                            ?>
                                <p class="thankyou-msg">Thanks for submitting your question. Use this reference if you need to follow up on your enquiry: <strong><?= $referenceId ?></strong></p>

                                <p class="result-msg">A member of our support team will respond to your enquiry.</p>
                                
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
