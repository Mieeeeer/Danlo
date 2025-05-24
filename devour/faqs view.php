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
                $elemLogo = $Content->findOne(['type' => 'school_logo', 'title' => 'elem_logo']);
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
            <h2>Frequently Asked Question</h2>

            <article class="faq-view">
                <h3><?= htmlspecialchars($faq['question']) ?></h3>
                <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
            </article>

            <a class="show-more-btn" href="faqs all elem.php">← Back to All FAQs</a>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-info">
            <div class="contact">
                <div class="logo-section-footer">
                    <?php
                        $elemLogo = $Content->findOne(['type' => 'school_logo', 'title' => 'elem_logo']);
                        if ($elemLogo && isset($elemLogo['img_path'])) {
                            echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Image">';
                        }
                    ?>
                    <h1>STA. ANA CENTRAL<br>ELEMENTARY SCHOOL</h1>
                </div>
                <br><br>
                <div class="contact-info">
                    <?php
                        $contactTitles = ['district_elem', 'city'];
                        foreach ($contactTitles as $title) {
                            $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);
                            if ($doc && isset($doc['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                            }
                        }

                        echo '<br>';

                        $contactDetails = ['elem_contactNo', 'elem_email'];
                        foreach ($contactDetails as $title) {
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
                    $elemMap = $Content->findOne(['type' => 'maps', 'title' => 'elem_maps']);
                    if ($elemMap && !empty($elemMap['iframe_link'])) {
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
