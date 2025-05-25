<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: admin-dashboard.php");
    exit();
}

// Create connection
$conn = new mysqli('localhost', 'root', '', 'school_portal');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminID = $_POST['adminID'] ?? '';
    $password = $_POST['password'] ?? ''; // Plain password from form

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM admin WHERE AdminID = ?");
    $stmt->bind_param("s", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if admin exists
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // For testing only — if stored as plain text 

        // ✅ Secure way: if Password_Hash is hashed 
       if ($password === $admin['Password_Hash']) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            header("Location: admin-dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Invalid Admin ID or password.";
        }
    } else {
        $_SESSION['login_error'] = "Invalid Admin ID or password.";
    }

    $stmt->close();
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="login.css" />
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

              <!-- AdminID Input -->
            <div class="input-box">
            <input type="text" name="adminID" id="adminID" placeholder="Admin ID" required />
             <i class='bx bxs-user'></i>
              <span id="adminIdError" class="error-message"></span>
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
            const adminID = document.getElementById("adminID").value.trim();
            const password = document.getElementById("password").value.trim();
            const adminIdError = document.getElementById("adminIdError");
            const passwordError = document.getElementById("passwordError");

            // Reset errors
            adminIdError.textContent = "";
            passwordError.textContent = "";

            // LRN validation
            if (!/^ADM\d{3,}$/.test(adminID)) {
            adminIdError.textContent = "Invalid Admin ID format (e.g., ADM001)";
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

