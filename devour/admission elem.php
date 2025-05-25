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
                <li><a href="admission elem.php">Admission</a></li>
                <li><a href="announcement elem.php">Announcement</a></li>
                <li><a href="faqs elem.php">FAQs</a></li>
                <li><a href="contact us elem.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="container-content">
                <div class="elem-admission-title">
                    <br><br>
                    <h1>Prospective Students</h1>

                    <?php
                        $admissionElem = $Admission->findOne([
                            'type' => 'admission',
                            'title' => 'admission-description',
                            'school-level' => 'elementary'
                        ]);

                        if ($admissionElem && isset($admissionElem['description'])) {
                            echo '<p>' . nl2br(htmlspecialchars($admissionElem['description'])) . '</p>';
                        } 
                    ?>
                </div>

                <section class="elem-student-header">
                        <div class="elem-student-title">
                            <h3>1. Kindergarten</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-kinder-description'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <section class="elem-student-header">
                        <div class="elem-student-title">
                            <h3>2. Grade 1</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-grade-1-description'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <section class="elem-student-header">
                        <div class="elem-student-title">
                            <h3>3. Continuing Pupils (Grade 2-6)</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-grade-2-6-description'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <section class="elem-student-header">
                        <div class="elem-student-title">
                            <h3>4. Transferees</h3>
                        </div>

                        <?php
                            $student = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-transferees-description'
                            ]);

                            if ($student && isset($student['description'])) {
                                echo '<p>' . nl2br(htmlspecialchars($student['description'])) . '</p>';
                            } 
                        ?>
                </section>

                <br>

                
                <section class="enrollment-process-elem">
                    <br><br>
                    <h1>Enrollment Process</h1>

                    <div class="enrollment-process-img">
                        <?php
                            $enrollmentProcess = $Admission->findOne([
                                'type' => 'admission',
                                'title' => 'admission-elem-img'
                            ]);

                            if ($enrollmentProcess && isset($enrollmentProcess['img_path'])) {
                                echo '<img src="' . htmlspecialchars($enrollmentProcess['img_path']) . '" alt="Image">';
                            }
                        ?>
                    </div>
                </section>
                
                <section class="downloadable-forms-header">
                    <div class="downloadable-forms-title-elem">
                        <h3>Downloadable Forms</h3>
                    </div>

                    <?php $forms = $Admission->find([
                        'type' => 'download-forms',
                        'school-level' => 'elementary'
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