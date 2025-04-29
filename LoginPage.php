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


$profilePic = !empty($student['ProfilePic']) ? 'uploads/' . htmlspecialchars($student['ProfilePic']) : '/api/placeholder/120/120';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
<div class="profile-wrapper">
    <div class="profile-header">
    <div class="profile-picture">
    <img src="<?= $profilePic ?>" alt="Student Profile Picture" width="100%" height="100%">
</div>
<form action="upload_pfp.php" method="POST" enctype="multipart/form-data" style="text-align: center; margin-top: 10px;">
    <input type="file" name="profile_pic" accept="image/*" required>
    <button type="submit" class="btn" style="margin-top: 10px;">Change Picture</button>
</form>
        <h1 class="profile-name"><?= htmlspecialchars($student['FirstName'] . ' ' . $student['LastName']) ?></h1>
        <div class="profile-id">Student LRN: <?= htmlspecialchars($student['LRN']) ?></div>
    </div>

    <div class="profile-details">
        <div class="detail-item">
            <i class="fas fa-graduation-cap"></i>
            <div class="label">Grade Level:</div>
            <div class="value"><?= htmlspecialchars($student['GradeLevel']) ?></div>
        </div>
        <div class="detail-item">
            <i class="fas fa-calendar"></i>
            <div class="label">Section:</div>
            <div class="value"><?= htmlspecialchars($student['Section']) ?></div>
        </div>
        <div class="detail-item">
            <i class="fas fa-envelope"></i>
            <div class="label">Email:</div>
            <div class="value"><?= htmlspecialchars($student['Email']) ?></div>
        </div>
        <div class="detail-item">
            <i class="fas fa-phone"></i>
            <div class="label">Phone:</div>
            <div class="value">(N/A)</div> <!-- You can replace with real phone field if available -->
        </div>
    </div>

    <div class="attendance-section">
        <div class="attendance-title">Attendance Rate: 85%</div>
        <div class="attendance-bar">
            <div class="attendance-progress" style="width:85%"></div>
        </div>
    </div>

    <div class="profile-buttons">
        <button class="btn">View Grades</button>
        <button class="btn">Course Schedule</button>
    </div>

    <a href="logout.php" class="logout-link">Logout <i class="fas fa-sign-out-alt"></i></a>
</div>
</body>
</html>