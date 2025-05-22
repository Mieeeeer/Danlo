<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="home">
        <!-- Header -->
        <header><h1>STA. ANA</h1></header>

        <!-- Container -->
        <main class="container">
            <h1>home contents here</h1><br><br>
        </main>

        <!-- Footer -->
        <footer>

            <div class="home-footer">
              <div class="home-footer-container">
                
                <div class="home-contacts-elem">
                    <?php
                        $titles = ['elem_school_name', 'district_elem', 'city', 'elem_email'];
                              
                            foreach ($titles as $title) {
                                $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                    ?>
                </div>

                <div class="home-maps">
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

                <div class="home-contacts-hs">
                    <?php
                        $titles = ['hs_school_name', 'district_hs', 'city', 'hs_email'];
                              
                            foreach ($titles as $title) {
                                $doc = $Content->findOne(['type' => 'contact', 'title' => $title]);

                                if ($doc && isset($doc['description'])) {
                                    echo '<p>' . nl2br(htmlspecialchars($doc['description'])) . '</p>';
                                }
                            }
                    ?>
                </div>

                <div class="home-maps">
                    <?php
                        $hsMap = $Content->findOne([
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
            </div>

            <div class="logos">
                <?php
                    $titles = ['deped_logo', 'elem_logo', 'city', 'hs_logo'];
                              
                    foreach ($titles as $title) {
                        $doc = $Content->findOne(['type' => 'school_logo', 'title' => $title]);

                        if ($doc && isset($doc['img_path'])) {
                            echo '<img src="' . htmlspecialchars($doc['img_path']) . '" alt="Image">';
                        }
                    }
                ?>
            </div>
            
            <div class="home-copyright">
                <p>Copyright © 2025 Sta. Ana Central Elementary School & Sta. Ana National High School</p>
            </div>
            
        </footer>

    </body>
</html>