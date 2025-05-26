<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana Nationa High School - Programs Offered</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="hs">
        <!-- Header -->
        <header>
            <div class="logo-section">
                <?php
                    $elemLogo = $Logo->findOne([
                        'type' => 'school_logo',
                        'title' => 'hs_logo'
                    ]);

                    if ($elemLogo && isset($elemLogo['img_path'])) {
                        echo '<img src="' . htmlspecialchars($elemLogo['img_path']) . '" alt="Image">';
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
                <br>
                <section class="programs-offered-section">
                    <?php
                        // Header and Introduction
                        $programHeader = $Programs_HS ->findOne([
                            'type' => 'program_intro', 
                            'title' => 'program-header'
                        ]);
                        $programContent = $Programs_HS->findOne([
                            'type' => 'program_intro', 
                            'title' => 'program-content'
                        ]);
                        $topImage = $Programs_HS->findOne([
                            'type' => 'program', 
                            'title' => 'program-top-img'
                        ]);

                        echo '<div class="program-intro-flex">';
                        echo '  <div class="program-text">';
                        echo '    <h2>' . htmlspecialchars($programHeader['description']) . '</h2>';
                        echo '    <p>' . nl2br(htmlspecialchars($programContent['description'])) . '</p>';
                        echo '  </div>';

                        if ($topImage && isset($topImage['img_path'])) {
                            echo '<div class="program-image">';
                            echo '  <img src="' . htmlspecialchars($topImage['img_path']) . '" alt="Program Top Image">';
                            echo '</div>';
                        }
                            
                        echo '</div>';

                        // Junior High Header
                        $coreHeader = $Programs_HS->findOne([
                            'type' => 'programs', 
                            'title' => 'junior-high'
                        ]);
                        echo '<h3 class="red-box">' . htmlspecialchars($coreHeader['description']) . '</h3>';

                            $subject = $Programs_HS->findOne([
                                'type' => 'programs', 
                                'title' => "junior-high-program-title"
                            ]);

                            $desc = $Programs_HS->findOne([
                                'type' => 'programs', 
                                'title' => "junior-high-program-description"
                            ]);

                            if ($subject && $desc) {
                                echo '<h4 class="subject-header">' . htmlspecialchars($subject['description']) . '</h4>';
                                echo '<p class="subject-description">' . nl2br(htmlspecialchars($desc['description'])) . '</p>';
                            }

                        // Senior High Header
                        $coreHeader = $Programs_HS->findOne(['type' => 'programs', 'title' => 'senior-high']);
                        echo '<h3 class="red-box">' . htmlspecialchars($coreHeader['description']) . '</h3>';

                        $tracksCursor = $Programs_HS->find(['type' => 'track']);
                        $strandsCursor = $Programs_HS->find(['type' => 'strand']);

                        // Step 2: Organize tracks and group strands by track_key
                        $tracks = [];
                        foreach ($tracksCursor as $track) {
                            $track_key = $track['track_key'];
                            $tracks[$track_key] = [
                                'title' => $track['title'],
                                'intro' => $track['intro'],
                                'strands' => []
                            ];
                        }

                        // Step 3: Add each strand under its track
                        foreach ($strandsCursor as $strand) {
                            $track_key = $strand['track_key'];
                            if (isset($tracks[$track_key])) {
                                $tracks[$track_key]['strands'][] = [
                                    'title' => $strand['title'],
                                    'description' => $strand['description']
                                ];
                            }
                        }

                        foreach ($tracks as $track):
                            echo '<h2 class="track-title">' . htmlspecialchars($track['title']) . '</h2>';
                            echo '<p class="intro">' . htmlspecialchars($track['intro']) . '</p>';

                            foreach ($track['strands'] as $strand):
                                echo '<div class="strand">';
                                    echo '<div class="strand-title">' . htmlspecialchars($strand['title']) . '</div>';
                                    echo '<div class="strand-description">' . htmlspecialchars($strand['description']) . '</div>';
                                echo '</div>';
                            endforeach;
                            echo '<div class="divider"></div>';
                        endforeach;

                        // Extra Curricular header
                        $coreHeader = $Programs_HS->findOne(['type' => 'programs', 'title' => 'extra-cur']);
                        echo '<h3 class="red-box">' . htmlspecialchars($coreHeader['description']) . '</h3>';

                        // Get all extracurricular activities (no category needed)
                        $activities = iterator_to_array($Programs_HS->find(['type' => 'extracurricular']));

                        // Count and split in half
                        $total = count($activities);
                        $half = ceil($total / 2);
                        $leftColumn = array_slice($activities, 0, $half);
                        $rightColumn = array_slice($activities, $half);

                        echo'<div class="extracurricular-flex-list">';
                            foreach ($activities as $activity): 
                                echo'<div class="activity-item">' . htmlspecialchars($activity['description']) . '</div>';
                            endforeach;
                        echo'</div>';
                    ?>

                    <?php
                        // Activity image
                        $scrollableImages = [
                            $Programs->findOne(['type' => 'program', 'title' => 'program-scrollable-1-img']),
                            $Programs->findOne(['type' => 'program', 'title' => 'program-scrollable-2-img']),
                            $Programs->findOne(['type' => 'program', 'title' => 'program-scrollable-3-img']),
                        ];

                        echo '<div class="school-activity-slideshow-wrapper">';
                        echo '  <div class="school-activity-slideshow" id="slideContainer">';
                        foreach ($scrollableImages as $img) {
                            if ($img && isset($img['img_path'])) {
                                echo '<img class="slide-img" src="' . htmlspecialchars($img['img_path']) . '" alt="Activity">';
                            }
                        }
                            
                        echo '  </div>';
                        echo '  <div id="slideDots" class="slide-dots"></div>';  // Dots inside wrapper
                        echo '</div>';
                    ?>

                    <?php
                        $documents = $Programs_HS->find();
                        $overview = '';
                        $mission = '';
                        $special_programs = [];

                        foreach ($documents as $doc) {
                            switch ($doc['type']) {
                                case 'overview_content':
                                    $overview = $doc['description'];
                                    break;
                                case 'mission_content':
                                    $mission = $doc['description'];
                                    break;
                                case 'special_program':
                                    $special_programs[] = [
                                        'title' => $doc['title'],
                                        'description' => $doc['description']
                                    ];
                                    break;
                            }
                        }
                    ?>

                    <div class="bottom-nav">
                        <div class="button-box">
                            <button class="button tab-button active" onclick="showTab('overview')">Overview</button>
                            <button class="button tab-button" onclick="showTab('curriculum')">Special Programs</button>
                            <button class="button tab-button" onclick="showTab('mission')">Mission Statement</button>
                        </div>

                        <!-- Overview Tab -->
                        <div class="tab-content" id="overview">
                            <div class="content-section">
                                <div class="bottom-nav-container">
                                    <p><?php echo nl2br(htmlspecialchars($overview)); ?></p>
                                </div>
                            </div>
                         </div>

                        <!-- Curriculum Tab -->
                        <div class="tab-content" id="curriculum" style="display: none;">
                                <div class="bottom-nav-container">
                                    <?php foreach ($special_programs as $program): ?>
                                        <div class="program-box">
                                            <h3><?php echo htmlspecialchars($program['title']); ?></h3>
                                            <p><?php echo nl2br(htmlspecialchars($program['description'])); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                        </div>

                        <!-- Mission Statement Tab -->
                        <div class="tab-content" id="mission" style="display: none;">
                            <div class="content-section">
                                <div class="bottom-nav-container">
                                    <p><?php echo nl2br(htmlspecialchars($mission)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>

            </section>

        </div>
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

        <script>
            window.onload = function () {
                // TAB SWITCHING
                function showTab(tabName) 
                {
                // Hide all tab contents
                const tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(tab => {
                    tab.style.display = 'none';
                });
                
                // Remove active class from all buttons
                const tabButtons = document.querySelectorAll('.tab-button');
                tabButtons.forEach(button => {
                    button.classList.remove('active');
                });
                
                // Show selected tab
                document.getElementById(tabName).style.display = 'block';
                
                // Add active class to clicked button
                event.target.classList.add('active');
                }

                window.showTab = showTab;

                // SLIDESHOW
                const slideContainer = document.getElementById("slideContainer");
                const slides = document.querySelectorAll(".slide-img");
                const dotsContainer = document.getElementById("slideDots");

                let currentSlide = 0;
                const totalSlides = slides.length;

                // Create dots
                for (let i = 0; i < totalSlides; i++) {
                    const dot = document.createElement("span");
                    dot.classList.add("slide-dot");
                    if (i === 0) dot.classList.add("active");
                    dot.setAttribute("data-slide", i);
                    dot.addEventListener("click", () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }

                function updateDots(index) {
                    const dots = document.querySelectorAll(".slide-dot");
                    dots.forEach(dot => dot.classList.remove("active"));
                    if (dots[index]) dots[index].classList.add("active");
                }

                function goToSlide(index) {
                    slideContainer.style.transform = `translateX(-${index * 100}%)`;
                    currentSlide = index;
                    updateDots(index);
                }

                setInterval(() => {
                    let nextSlide = (currentSlide + 1) % totalSlides;
                    goToSlide(nextSlide);
                }, 5000);
            };
        </script>
    </body>
</html>