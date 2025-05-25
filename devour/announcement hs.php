<?php include 'db.php'; ?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sta. Ana School</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body class="hs">
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
                <li><a href="">Programs Offered</a></li>
                <li><a href="admission hs.php">Admission</a></li>
                <li><a href="announcement hs.php">Announcement</a></li>
                <li><a href="faqs hs.php">FAQs</a></li>
                <li><a href="contact us hs.php">Contact Us</a></li>
            </ul>
        </nav>
        
        <!-- Container -->
        <main class="container">
            <br>
            <section class="announcement-updates">
                <h1 class="sanhs-updates">SANHS UPDATES</h1>
            </section>

            <div class="announcement-container">
                <div class="latest-updates">

                    <?php
                        $filter = [
                            'type' => 'announcement',
                            'school_level' => 'highschool'
                        ];
                        $options = [
                            'sort' => ['created_at' => -1],
                        ];

                        $announcements = $AnnouncementLink->find($filter, $options);                    
                    ?>

                    <section class="announcement-slider">
                        <div class="announcement-slider-cards">
                            <?php foreach ($announcements as $announcement): ?>
                            <div class="announcement-slider-card">
                                <div class="iframe-wrapper">
                                    <iframe 
                                        src="<?= htmlspecialchars($announcement['iframe_link']) ?>" 
                                        width="380" 
                                        height="380" 
                                        style="border:none;overflow:hidden" 
                                        scrolling="no" 
                                        frameborder="0" 
                                        allowfullscreen="true" 
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                                    </iframe>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div> 
            </div>

            <button class="slider-btn-left-hs" onclick="slideLeft()">‹</button>               
            <button class="slider-btn-right-hs" onclick="slideRight()">›</button>
            
        <h1 class="sanhs-calendar">SANHS CALENDAR</h1>

            <div class="calendar">

                <div class="calendar-header">
                    <button id="prev-month">&lt;</button>
                    <h2 id="calendar-month-year"></h2>
                    <button id="next-month">&gt;</button>
                </div>

                <div class="calendar-days">
                    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div>
                    <div>Thu</div><div>Fri</div><div>Sat</div>
                </div>

                <div class="calendar-dates" id="calendar-dates"></div>
            </div>

            <div class="calendar-events">
                <h3>Events</h3>
                <ul id="event-list">
                    <li>Select a day to view events.</li>
                </ul>
            </div>

            <?php
            
            require 'vendor/autoload.php';

            $client = new MongoDB\Client("mongodb://localhost:27017");
            $collection = $client->Sta_Ana->Announcement;

            $cursor = $collection->find([
                'type' => 'event',
                'school-level' => 'highschool'
            ]);
            $events = [];

            foreach ($cursor as $event) {
                $date = $event['date'];
                $title = $event['title'];

                if (!isset($events[$date])) {
                    $events[$date] = [];
                }
                $events[$date][] = $title;
            }

            $jsonEvents = json_encode($events);
            ?>

            <link rel="stylesheet" href="calendar hs.css">
            <script>
                const events = <?php echo $jsonEvents; ?>;
            </script>
            <script src="calendar.js" defer></script>


            <br>


            <section class="important-dates-hs">
                <?php
                    $importantDatesHs = $Announcements->find([
                        'type' => 'important-dates',
                        'school-level' => 'highschool'
                    ]);
                ?>

                <section class="calendar-important-dates">
                    <?php foreach ($importantDatesHs as $importantHsDate): ?>
                        <div class="calendar-card">
                            <div class="month"><?= htmlspecialchars($importantHsDate['month']) ?></div>
                            <div class="day"><?= htmlspecialchars($importantHsDate['day']) ?></div>
                            <div class="label"><?= htmlspecialchars($importantHsDate['label']) ?></div>
                        </div>
                    <?php endforeach; ?>
                </section>
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
    
        <script>
        function slideLeft() {
            document.querySelector('.announcement-slider').scrollBy({ left: -400, behavior: 'smooth' });
        }

        function slideRight() {
            document.querySelector('.announcement-slider').scrollBy({ left: 400, behavior: 'smooth' });
        }
        </script>
    </body>
</html>