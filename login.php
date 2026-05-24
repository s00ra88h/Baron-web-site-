<?php
// Author: Shoug Aldossary
// Admin login page using sessions and cookies

session_start();

// Redirect admin if already logged in
if (isset($_SESSION['admin_name'])) {
    header("Location: ManagingProducts.php");
    exit();
}

// Login using saved cookie
if (isset($_COOKIE['admin_name'])) {
    $_SESSION['admin_name'] = $_COOKIE['admin_name'];
    header("Location: ManagingProducts.php");
    exit();
}
// Database connection
include("Connect.php");
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check empty fields
    if (empty($_POST['admin_name']) || empty($_POST['password'])) {
        $error = "Username and Password are required";

    } else {
        try {
            // Get admin data from database
            $sql  = "SELECT admin_name, password FROM admins WHERE admin_name = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['admin_name']]);
            $row  = $stmt->fetch();

            // Validate login information
            if ($row && $row['password'] === $_POST['password']) {

                // Store admin session
                $_SESSION['admin_name'] = $row['admin_name'];

                // Save login cookie for 1 day
                setcookie("admin_name", $row['admin_name'], time() + 60 * 60 * 24, "/");

                header("Location: ManagingProducts.php");
                exit();

            } else {
                $error = "Invalid Username or Password";
            }

        } catch (PDOException $e) {

            // Database error handling
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>
    <img src="Images/logo.png" class="corner-img">
    <img src="Images/plant.png" class="corner-right">

    <h1 id="auth-title">Admin Login</h1>
    <br><hr>
    <div class="sh_container">

        <form class="login-form" method="POST" action="login.php">
            <input type="text" name="admin_name" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" class="auth_button">Login</button>
        </form>

        
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
    </div>
</body>

<footer class="tall_footer"></footer>
</html>