<?php
session_start();
if (!isset($_SESSION['lrn'])) {
    header("Location: login.php");
    exit();
}

$lrn = $_SESSION['lrn'];

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
    $fileName = $_FILES['profile_pic']['name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($fileExt, $allowedExts)) {
        die("Invalid file type.");
    }

    $newFileName = uniqid('pfp_', true) . '.' . $fileExt;
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $destPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $conn = new mysqli('localhost', 'root', '', 'school_portal');
        if ($conn->connect_error) {
            die("DB Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE student SET ProfilePic = ? WHERE LRN = ?");
        $stmt->bind_param("ss", $newFileName, $lrn);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        header("Location: LoginPage.php?upload=success");
        exit();
    } else {
        die("Failed to move uploaded file.");
    }
} else {
    die("No file uploaded.");
}
?>
