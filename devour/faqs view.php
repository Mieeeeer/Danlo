<?php
include 'db.php';

$id = $_GET['id'] ?? null;


if (!$id) {
    echo "Invalid FAQ ID.";
    exit;
}

try {
    $objectId = new MongoDB\BSON\ObjectId($id);
} catch (Exception $e) {
    echo "Invalid FAQ ID format.";
    exit;
}

$faq = $FAQs->findOne(['_id' => $objectId]);

if (!$faq) {
    echo "FAQ not found.";
    exit;
}

$date = $faq['createdAt'] ?? null;
if (!empty($date)) {
    if ($date instanceof MongoDB\BSON\UTCDateTime) {
        $formattedDate = $date->toDateTime()->format('F j, Y g:i A');
    } else {
        $formattedDate = $date;
    }
} else {
    $formattedDate = "Published time not found";
}

// Increment view count
$FAQs->updateOne(['_id' => $objectId], ['$inc' => ['views' => 1]]);
?>

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
            <li><a href="">Programs Offered</a></li>
            <li><a href="">Admission</a></li>
            <li><a href="">Announcement</a></li>
            <li><a href="faqs all elem.php">FAQs</a></li>
            <li><a href="">Contact Us</a></li>
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

                    <div class="home-question">
                        <a class="home-btn-view" href="faqs all elem.php">Home</a>
                        <p class="arrow">></p>
                        <a class="question-name" href="faqs all elem.php"><?= htmlspecialchars($faq['question']) ?></a>
                    </div>

                    <article class="faq-view">
                        <h3 class="question"><?= htmlspecialchars($faq['question']) ?></h3>
                        <p class="published">Published at <?= htmlspecialchars($formattedDate) ?></p>
                        <p class="answer"><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                    </article>

                    <div class="to-feedback-response">
                        <p class="feedback-question">Is this answer helpful?</p>
                        <a class="feedback-yes-btn" href="faqs feedback.php?feedback=yes">YES</a>
                        <a class="feedback-no-btn" href="faqs feedback.php?feedback=no">NO</a>
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
