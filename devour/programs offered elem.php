<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana Central Elementary School - Programs Offered</title>
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
                <li><a href="programs offered elem.php">Programs Offered</a></li>
                <li><a href="admission elem.php">Admission</a></li>
                <li><a href="announcement elem.php">Announcement</a></li>
                <li><a href="faqs elem.php">FAQs</a></li>
                <li><a href="contact us elem.php">Contact Us</a></li>
            </ul>
        </nav>

        <!-- Container -->
        <main class="container">
            <div class="container-content">
                <br>
                <section class="programs-offered-section">
                <?php
                            // Header and Introduction
                            $programHeader = $Programs  ->findOne([
                                'type' => 'program_intro', 
                                'title' => 'program-header'
                            ]);
                            $programContent = $Programs->findOne([
                                'type' => 'program_intro', 
                                'title' => 'program-content'
                            ]);
                            $topImage = $Programs->findOne([
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

                            // Core Subjects Header
                            $coreHeader = $Programs->findOne(['type' => 'core_subject', 'title' => 'core-subject-header']);
                            echo '<h3 class="red-box">' . htmlspecialchars($coreHeader['description']) . '</h3>';

                            // Core Subjects Loop
                            for ($i = 1; $i <= 5; $i++) {
                                $subject = $Programs->findOne(['type' => 'core_subject', 'title' => "core-subject-subjects-$i"]);
                                $desc = $Programs->findOne(['type' => 'core_subject', 'title' => "core-subject-description-$i"]);
                                if ($subject && $desc) {
                                    echo '<h4 class="subject-header">' . htmlspecialchars($subject['description']) . '</h4>';
                                    echo '<p class="subject-description">' . nl2br(htmlspecialchars($desc['description'])) . '</p>';
                                    echo '<div class="divider"></div>';
                                }
                            }
                        ?>


                        <div class="special-extra-wrapper">
                            <div class="special-column">
                                <?php
                                    $specialHeader = $Programs->findOne(['type' => 'special_subject', 'title' => 'special-subject-header']);
                                    echo '<h3 class="red-box">' . htmlspecialchars($specialHeader['description']) . '</h3>';
                                    echo '<ul>';
                                    for ($i = 1; $i <= 6; $i++) {
                                        $special = $Programs->findOne(['type' => 'special_subject', 'title' => "special-subject-subjects-$i"]);
                                        if ($special) {
                                            echo '<li>' . htmlspecialchars($special['description']) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                ?>
                            </div>

                            <div class="extracurricular-column">
                                <?php
                                    $extraHeader = $Programs->findOne(['type' => 'extracurricular_activities', 'title' => 'extracurrilar-activities-header']);
                                    echo '<h3 class="red-box">' . htmlspecialchars($extraHeader['description']) . '</h3>';
                                    echo '<ul>';
                                    for ($i = 1; $i <= 3; $i++) {
                                        $extra = $Programs->findOne(['type' => 'extracurricular_activities', 'title' => "extracurricular-activities-club-$i"]);
                                        if ($extra) {
                                            echo '<li>' . htmlspecialchars($extra['description']) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                ?>
                            </div>
                        </div>
                        
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
                        // Get content from MongoDB
                        $overview = $Programs->findOne(['type' => 'overview_content', 'title' => 'overview-description']);
                        $curriculumDocs = $Programs->find(['type' => 'grade_level']);
                        $mission = $Programs->findOne(['type' => 'mission_content', 'title' => 'mission-description']);
                        ?>

                        <div class="bottom-nav">
                            <div class="button-box">
                                <button class="button tab-button active" onclick="showTab('overview')">Overview</button>
                                <button class="button tab-button" onclick="showTab('curriculum')">Curriculum</button>
                                <button class="button tab-button" onclick="showTab('mission')">Mission Statement</button>
                            </div>

                            <!-- Overview Tab -->
                            <div class="tab-content" id="overview">
                                <div class="content-section">
                                    <div class="content-body">
                                        <p><?= nl2br(htmlspecialchars($overview['description'] ?? 'Overview content not found.')) ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Curriculum Tab -->
                            <div class="tab-content" id="curriculum" style="display: none;">
                                <div class="curriculum-content">
                                    <div class="curriculum-grid">
                                        <?php 
                                        // Define grade level mappings for CSS classes
                                        $gradeClasses = [
                                            'Kinder' => 'kinder',
                                            'First Grade' => 'first-grade', 
                                            'Second Grade' => 'second-grade',
                                            'Third Grade' => 'third-grade',
                                            'Fourth Grade' => 'fourth-grade',
                                            'Fifth Grade' => 'fifth-grade',
                                            'Sixth Grade' => 'sixth-grade'
                                        ];
                                        
                                        foreach ($curriculumDocs as $grade): 
                                            $gradeTitle = htmlspecialchars($grade['title']);
                                            $cssClass = $gradeClasses[$gradeTitle] ?? 'default-grade';
                                        ?>
                                            <div class="grade-card <?= $cssClass ?>">
                                                <h3 class="grade-title"><?= $gradeTitle ?></h3>
                                                <ul class="subject-list">
                                                    <?php foreach ($grade['description'] as $item): ?>
                                                        <li class="subject-item">
                                                            <span class="subject-name"><?= htmlspecialchars($item['subject']) ?>:</span>
                                                            <span class="subject-detail"><?= htmlspecialchars($item['detail']) ?></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                            <div class="image-card">
                                                <?php
                                                // DepEd image
                                                $ProgramsDepEd = $Programs->findOne([
                                                    'type' => 'program',
                                                    'title' => 'program-deped-img'
                                                ]);

                                                if ($ProgramsDepEd && isset($ProgramsDepEd['img_path'])) {
                                                    echo '<div class="deped-image-container">';
                                                    echo '<img src="' . htmlspecialchars($ProgramsDepEd['img_path']) . '" alt="DepEd Program Image">';
                                                    echo '</div>';
                                                }
                                                ?>
                                            </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Mission Statement Tab -->
                            <div class="tab-content" id="mission" style="display: none;">
                                <div class="content-section">
                                    <div class="content-body">
                                        <p><?= nl2br(htmlspecialchars($mission['description'] ?? 'Mission Statement content not found.')) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <br>
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