<?php
session_start();
if (!isset($_SESSION['lrn'])) {
    header("Location: login.php");
    exit();
}

// Connect to DB
$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lrn = $_SESSION['lrn'];

// Fetch student info
$stmt = $conn->prepare("SELECT * FROM student WHERE LRN = ?");
$stmt->bind_param("s", $lrn);
$stmt->execute();
$result = $stmt->get_result();

// Error check
if ($result->num_rows === 0) {
    die("Student not found.");
}

$student = $result->fetch_assoc(); 
$stmt->close();
$conn->close();

// Static data for profile display
$attendanceRate = 85;
$completionRate = 92;

$profilePic = !empty($student['ProfilePic']) ? 'uploads/' . htmlspecialchars($student['ProfilePic']) : '/api/placeholder/120/120';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - <?= htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="loginpage.css">
    
</head>
<body>
    <div class="profile-container">
        <a href="logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

        <div class="profile-sidebar">
            <div class="profile-picture-container">
                <div class="profile-picture">
                    <img src="<?= $profilePic ?>" alt="Student Profile Picture">
                    <div class="profile-picture-overlay">
                        <i class="fas fa-camera" style="color: white; font-size: 20px;"></i>
                    </div>
                </div>
            </div>

            <form class="upload-form" action="upload_pfp.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="old_pic" value="<?= htmlspecialchars($student['ProfilePic'] ?? '') ?>">
    <label for="profile-pic-input" class="file-input-wrapper">
        <i class="fas fa-upload"></i> Change Picture
        <input type="file" id="profile-pic-input" name="profile_pic" accept="image/*" style="display: none;" onchange="this.form.submit();">
    </label>
</form>

            <h1 class="student-name"><?= htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']) ?></h1>
            <div class="student-lrn">LRN: <?= htmlspecialchars($student['LRN']) ?></div>

            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-number"><?= $attendanceRate ?>%</div>
                    <div class="stat-label">Attendance</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?= $completionRate ?>%</div>
                    <div class="stat-label">Completion</div>
                </div>
            </div>
        </div>

        <div class="profile-main">
            <div>
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Student Information
                </h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Grade Level</div>
                        <div class="info-value">Grade <?= htmlspecialchars($student['GradeLevel']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Section</div>
                        <div class="info-value"><?= htmlspecialchars($student['Section']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value"><?= htmlspecialchars($student['Email']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Student Status</div>
                        <div class="info-value">Active</div>
                    </div>
                </div>
            </div>

            

            <div class="action-buttons">
                <a href="grades.php" class="btn btn-primary">
                    <i class="fas fa-chart-bar"></i>
                    View Grades
                </a>
                <a href="schedule.php" class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i>
                    Class Schedule
                </a>
            
                </a>
                <a href="attendance.php" class="btn btn-secondary">
                    <i class="fas fa-clock"></i>
                    Attendance
                </a>
            </div>
        </div>
    </div>

    <div id="notification" class="notification">
        Profile picture updated successfully!
    </div>

    <script>
        // Show notification if there's a success parameter in URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('upload') === 'success') {
            const notification = document.getElementById('notification');
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Animate progress bars on load
        window.addEventListener('load', () => {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Add smooth hover effects
        document.querySelectorAll('.info-item, .btn').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>