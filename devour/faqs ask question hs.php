<?php
include 'db.php';

$successMsg = $errorMsg = "";
$referenceId = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Handle form submission
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $question = htmlspecialchars(trim($_POST['question']));

    $document = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'subject' => $subject,
        'question' => $question,
        'status' => 'pending',
        'submitted_at' => new MongoDB\BSON\UTCDateTime()
    ];

    try {
        $result = $FAQs_Submissions_HS->insertOne($document);
        $successMsg = "Your question has been submitted successfully!";
        $referenceId = (string)$result->getInsertedId();
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'faqs ask confirmation hs.php?ref={$referenceId}';
                }, 5);
              </script>";
    } catch (Exception $e) {
        $errorMsg = "Error submitting your question: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sta. Ana National High School - FAQs/Ask a Question</title>
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
            <li><a href="programs offered hs.php">Programs Offered</a></li>
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
            <h2>FREQUENTLY ASKED QUESTIONS</h2>

                <header class="top-nav">
                        <nav>
                            <ul>
                                <li><a href="faqs hs.php">Home</a></li>
                                <li><a href="faqs ask question hs.php" class="active">Ask a Question</a></li>
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
                        
                            
                            <?php if (!empty($successMsg)): ?>
                                <p style="color: green;" class="clarity-msg"><?= htmlspecialchars($successMsg) ?></p>

                            <?php elseif (!empty($errorMsg)): ?>
                                <p style="color: red;" class="clarity-msg"><?= htmlspecialchars($errorMsg) ?></p>
                            <?php endif; ?>
                        
                        <form method="POST" action="" class="faq-form">

                            <label for="first_name">First Name <span style="color:red">*</span></label>
                            <input type="text" name="first_name" id="first_name" required>

                            <label for="last_name">Last Name <span style="color:red">*</span></label>
                            <input type="text" name="last_name" id="last_name" required>

                            <label for="email">Email Address <span style="color:red">*</span></label>
                            <input type="email" name="email" id="email" required>

                            <label for="subject">Subject <span style="color:red">*</span></label>
                            <input type="text" name="subject" id="subject" required>

                            <label for="question">Question <span style="color:red">*</span></label>
                            <textarea name="question" id="question" rows="6" required></textarea>

                            <p class="privacy-note">
                            The information you provide will be used solely for the purpose of recording and responding to your inquiry.
                            It will be handled in accordance with the school’s data privacy policies and the provisions of the Data Privacy Act of 2012.
                            Your personal information will not be shared with any third parties without your consent.
                            <br><br>
                            With your permission, the school may also use your contact details to send important updates or relevant information
                            about school activities and announcements.
                            </p>

                            <button type="submit" class="submit-btn">SUBMIT YOUR QUESTION</button>
                            
                        </form>

                        
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
