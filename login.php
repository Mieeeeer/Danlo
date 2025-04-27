<?php
// Create connection
$conn = new mysqli('localhost', 'root', '', 'school_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: {$conn->connect_error}");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lrn = $_POST['lrn'] ?? '';
    $password = $_POST['password'] ?? '';

    // Use prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM student WHERE LRN = ? AND Password_Hash = ?");
    $stmt->bind_param("is", $lrn, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Login successful!";
        // You can also redirect or start a session here
    } else {
        echo "Invalid LRN or password.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <img src="images/Sta. Ana Elem logo.png" alt="School Logo" class="logo" />
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="lrn" placeholder="LRN" required> 
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required> 
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember Me </label>
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="btn">Login</button> 
            <div class="register-link">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</body>
</html>
