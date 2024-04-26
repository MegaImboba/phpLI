<?php
include '../config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Экранирование входных данных для предотвращения SQL инъекций
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Считывание пароля напрямую

    // Подготовленный запрос для защиты от SQL инъекций
    $sql = "SELECT id, password, is_admin FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Установка сессионных переменных
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $row['is_admin']; // Сохранение статуса администратора в сессии
            header("location: index.php");
            exit();
        } else {
            $error = "Your Login Name or Password is invalid";
        }
    } else {
        $error = "Your Login Name or Password is invalid";
    }
} include '../templates/login.html'
?>

<?php if (!empty($error)) echo '<p>' . $error . '</p>'; ?>
