<?php
session_start();

if (!isset($_SESSION['lrn'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'school_portal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$lrn = $_SESSION['lrn'];

// Get StudentID and GradeLevel from LRN
$stmtID = $conn->prepare("SELECT StudentID, GradeLevel FROM student WHERE LRN = ?");
$stmtID->bind_param("s", $lrn);
$stmtID->execute();
$resID = $stmtID->get_result();
$student = $resID->fetch_assoc();
$studentID = $student['StudentID'];
$currentGradeLevel = $student['GradeLevel'];
$stmtID->close();

// Check selected grade level from dropdown (default: current student grade)
$selectedGradeLevel = isset($_GET['grade']) ? $_GET['grade'] : $currentGradeLevel;

// Get all available grade levels (for dropdown)
$gradeLevels = [];
$result = $conn->query("SELECT DISTINCT GradeLevel FROM subject ORDER BY GradeLevel");
while ($row = $result->fetch_assoc()) {
    $gradeLevels[] = $row['GradeLevel'];
}

// Fetch grades for selected grade level
$stmt = $conn->prepare("
    SELECT s.SubjectName, g.Quarter, g.Score 
    FROM grades g
    JOIN subject s ON g.SubjectID = s.SubjectID
    WHERE g.StudentID = ? AND s.GradeLevel = ?
    ORDER BY s.SubjectName, g.Quarter
");
$stmt->bind_param("ss", $studentID, $selectedGradeLevel);
$stmt->execute();
$result = $stmt->get_result();

$grades = [];
while ($row = $result->fetch_assoc()) {
    $grades[$row['SubjectName']][$row['Quarter']] = $row['Score'];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Grades</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #870000 0%, #870000 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .grades-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 1000px;
            overflow-x: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .grade-select-form {
            text-align: center;
            margin-bottom: 20px;
        }

        select {
            padding: 8px 16px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            margin-left: 10px;
        }

        button {
            padding: 8px 16px;
            border: none;
            background-color: #870000;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            margin-left: 10px;
        }

        button:hover {
            background-color: #a00000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 14px;
            text-align: center;
        }

        th {
            background-color: #870000;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f7f7f7;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #870000;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .grades-container {
                padding: 20px;
            }

            th, td {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="grades-container">
        <h2>My Grades</h2>

        <form class="grade-select-form" method="GET">
            <label for="grade">Select Grade Level:</label>
            <select name="grade" id="grade">
                <?php foreach ($gradeLevels as $grade): ?>
                    <option value="<?= $grade ?>" <?= $grade == $selectedGradeLevel ? 'selected' : '' ?>>
                        Grade <?= $grade ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">View</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Quarter 1</th>
                    <th>Quarter 2</th>
                    <th>Quarter 3</th>
                    <th>Quarter 4</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grades as $subject => $quarters): ?>
                    <tr>
                        <td><?= htmlspecialchars($subject) ?></td>
                        <td><?= $quarters['1'] ?? '-' ?></td>
                        <td><?= $quarters['2'] ?? '-' ?></td>
                        <td><?= $quarters['3'] ?? '-' ?></td>
                        <td><?= $quarters['4'] ?? '-' ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($grades)): ?>
                    <tr><td colspan="5">No grades found for Grade <?= htmlspecialchars($selectedGradeLevel) ?>.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="LogInPage.php" class="back-link">&larr; Back to Profile</a>
    </div>
</body>
</html>
