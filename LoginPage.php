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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('/api/placeholder/1920/1080') no-repeat;
            background-size: cover;
            background-position: center;
        }

        .profile-wrapper {
            width: 420px;
            background: #b71c1c;
            color: #fff;
            border-radius: 10px;
            padding: 30px 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .profile-picture {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 3px solid #fff;
    margin: 0 auto 15px;
    display: block;
    background-color: #f0f0f0;
    overflow: hidden;
}

.profile-picture img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

        .profile-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-id {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 20px;
        }

        .profile-details {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .detail-item {
            display: flex;
            margin-bottom: 10px;
            align-items: center;
        }

        .detail-item i {
            width: 25px;
            margin-right: 10px;
        }

        .detail-item .label {
            width: 120px;
            font-weight: 500;
        }

        .detail-item .value {
            flex: 1;
        }

        .profile-buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 12px 0;
            background: #fff;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            cursor: pointer;
            font-size: 14px;
            color: #b71c1c;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
        }

        .attendance-section {
            margin-top: 20px;
        }

        .attendance-title {
            font-size: 16px;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .attendance-bar {
            height: 10px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
            overflow: hidden;
        }

        .attendance-progress {
            height: 100%;
            width: 85%;
            background: #fff;
            border-radius: 5px;
        }

        .logout-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
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