<?php
// Create connection
$conn = new mysqli('localhost', 'root', '', 'school_portal');
session_start();

if(isset($_SESSION['lrn'])) {
    header("Location: loginpage.php");
    exit();
}


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
    $_SESSION['lrn'] = $lrn;
    header("Location: LoginPage.php");
    exit();
} else {
    $_SESSION['login_error'] = "Invalid LRN or password.";
    header("Location: login.php"); // redirect back to this page
    exit();
}


    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login_style.css" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>

    <div class="wrapper">
        <form action="login.php" method="POST" onsubmit="return validateForm()">
            <img src="images/Sta. Ana Elem logo.png" alt="School Logo" class="logo" />
            <h1>Login</h1>

            <?php $login_error = $_SESSION['login_error'] ?? ''; unset($_SESSION['login_error']);
                ?>

            <?php if (!empty($login_error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
            <?php endif; ?>

            <!-- LRN Input -->
            <div class="input-box">
                <input type="text" name="lrn" id="lrn" placeholder="LRN" required />
                <i class='bx bxs-user'></i>
                <span id="lrnError" class="error-message"></span>
            </div>

            <!-- Password Input -->
            <div class="input-box">
                <input type="password" name="password" id="password" placeholder="Password" required />
                <i class='bx bxs-lock-alt'></i>
                <span id="passwordError" class="error-message"></span>
            </div>

            <!-- Remember Me / Forgot -->
            <div class="remember-forgot">
                <label>
                    <input type="checkbox" name="remember" /> Remember Me
                </label>
                <a href="forgot_password.php">Forgot Password?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">Login</button>

            <!-- Register Link -->
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
        </form>
    </div>

    <!-- Client-side validation -->
    <script>
        function validateForm() {
            let valid = true;
            const lrn = document.getElementById("lrn").value.trim();
            const password = document.getElementById("password").value.trim();
            const lrnError = document.getElementById("lrnError");
            const passwordError = document.getElementById("passwordError");

            // Reset errors
            lrnError.textContent = "";
            passwordError.textContent = "";

            // LRN validation
            if (!/^\d+$/.test(lrn)) {
                lrnError.textContent = "LRN should contain only numbers";
                valid = false;
            }

            // Password validation
            if (password.length < 6) {
                passwordError.textContent = "Password must be at least 6 characters";
                valid = false;
            }

            return valid;
        }
    </script>
</body>
</html>

