<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana National High School - Admission</title>
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
            <div class="container-content">
                <div class="hs-admission-title">
                    <br><br>
                    <h1>Prospective Students</h1>

                    <?php
                        $admissionHs = $Admission->findOne([
                            'type' => 'admission',
                            'title' => 'admission-description',
                            'school-level' => 'highschool'
                        ]);

                        if ($admissionHs && isset($admissionHs['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($admissionHs['description'])) . '</p>';
                        } 
                    ?>
                </div>

                <section class="hs-student-header">
                        <div class="hs-student-title">
                            <h3>1. Incoming Students (Grade 7 and Grade 11)</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-incomming-students-description'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <section class="hs-student-header">
                        <div class="hs-student-title">
                            <h3>2. Transferees</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'Transferees-HS'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <section class="hs-student-header">
                        <div class="hs-student-title">
                            <h3>3. Continuing Students (Grade 8 - 10 and Grade 12)</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'Continuing Students'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <br>

                
                <section class="enrollment-process-hs">
                    <br><br>
                    <h1>Enrollment Process</h1>

                    <div class="enrollment-process-img">
                        <?php
                            $enrollmentProcess = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-hs-img'
                            ]);

                            if ($enrollmentProcess && isset($enrollmentProcess['img_path'])) {
                                echo '<img src="' . htmlspecialchars($enrollmentProcess['img_path']) . '" alt="Image">';
                            }
                        ?>
                    </div>
                </section>
                
                <section class="downloadable-forms-header">
                    <div class="downloadable-forms-title-hs">
                        <h3>Downloadable Forms</h3>
                    </div>

                    <?php $forms = $Admission->find([
                        'type' => 'download-forms',
                        'school-level' => 'highschool'
                    ]); ?>

                    <div class="forms-grid">
                        <?php
                            $formArray = iterator_to_array($forms);
                            $half = ceil(count($formArray) / 2);
                            $columns = array_chunk($formArray, $half);
                            
                            for ($i = 0; $i < 2; $i++) {
                                echo '<div>';
                                foreach ($columns[$i] as $form) {
                                    $title = htmlspecialchars($form['title']);
                                    $path = htmlspecialchars($form['file_path']);
                                    echo "<div class='form-item'><a href='$path' download>$title</a></div>";
                                }
                                echo '</div>';
                            }
                        ?>

                        <br>

                    </div>
                </section>
            </div>

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