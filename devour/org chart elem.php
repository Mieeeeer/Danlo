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
                <li><a href="contact us elem.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="elem-org-chart-title">
                <br><br>
                <h1>ORGANIZATIONAL CHART</h1>
            </div>

            <div class="org-chart">
                <?php
                    $elemOrgChart = $OrgChart->findOne([
                        'type' => 'org_chart',
                        'title' => 'elem_org_chart'
                    ]);

                    if ($elemOrgChart && isset($elemOrgChart['img_path'])) {
                        echo '<img src="' . htmlspecialchars($elemOrgChart['img_path']) . '" alt="Image">';
                    }
                ?>
            </div>
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