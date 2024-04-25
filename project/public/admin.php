<?php
include '../config/config.php';
session_start();

// Проверка наличия сессии и прав администратора


echo "<h1>Admin Dashboard</h1>";
echo "<a href='logout.php'>Logout</a><br><br>";

// Функция для подсчета количества зарегистрированных пользователей
function countUsers($conn) {
    $query = "SELECT COUNT(id) AS total_users FROM users";
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        return $row['total_users'];
    } else {
        return "Error: " . $conn->error;
    }
}

// Функция для предоставления прав администратора пользователю
function grantAdminRights($conn, $username) {
    $username = $conn->real_escape_string($username);
    $query = "UPDATE users SET is_admin = 1 WHERE username = '$username'";
    if ($conn->query($query)) {
        return "Admin rights granted to $username.";
    } else {
        return "Error updating record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    echo grantAdminRights($conn, $username);
}

$totalUsers = countUsers($conn);
echo "<p>Total registered users: $totalUsers</p>";
?>

<!-- Форма для предоставления прав администратора -->
<form method="post" action="">
    <label for="username">Enter username to grant admin rights:</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Grant Admin Rights</button>
</form>
