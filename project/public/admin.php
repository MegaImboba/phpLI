<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php'); // Перенаправляем не админов на страницу входа
    exit;
}

echo "<h1>Admin Dashboard</h1>";
echo "<a href='logout.php'>Logout</a><br><br>";

// Подключение к БД
$dbHost = 'localhost';
$dbUser = 'root';
$dbPassword = '';
$dbName = 'myapp';
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Функции управления пользователями
function fetchUsers($conn) {
    $query = "SELECT id, username, is_admin FROM users";
    $result = $conn->query($query);
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    return $users;
}

function updateUserAdminStatus($conn, $userId, $status) {
    $userId = intval($userId);
    $status = intval($status);
    $query = "UPDATE users SET is_admin = $status WHERE id = $userId";
    if ($conn->query($query)) {
        return "User status updated.";
    } else {
        return "Error updating record: " . $conn->error;
    }
}

function deleteUser($conn, $userId) {
    $userId = intval($userId);
    $query = "DELETE FROM users WHERE id = $userId";
    if ($conn->query($query)) {
        return "User deleted.";
    } else {
        return "Error deleting record: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        echo deleteUser($conn, $_POST['userId']);
    } elseif (isset($_POST['update'])) {
        echo updateUserAdminStatus($conn, $_POST['userId'], $_POST['isAdmin']);
    }
}

$users = fetchUsers($conn);
include '../templates/admin.html'
?>

