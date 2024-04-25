<?php
include '../config/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
</head>
<body>
    <h1>Welcome to the Application!</h1>
    <?php
    // Показать кнопку "Login" или "Register", если пользователь не вошел в систему
    if (!isset($_SESSION['username'])) {
        echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
    } else {
        echo "<p>Hello, " . htmlspecialchars($_SESSION['username']) . "!</p>";
        echo "<a href='logout.php'>Logout</a>";

        // Показать кнопку "Admin Page", если пользователь является администратором
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo " | <a href='admin.php'>Admin Page</a>";
        }
    }
    ?>
</body>
</html>
