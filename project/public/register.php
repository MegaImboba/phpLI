<?php
include '../config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Хэширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Проверка на существование пользователя
    $checkUser = $conn->prepare("SELECT id FROM users WHERE username=?");
    $checkUser->bind_param("s", $username);
    $checkUser->execute();
    $checkUser->store_result();
    if ($checkUser->num_rows == 0) {
        $checkUser->close();
        // Добавление пользователя в БД
        $stmt = $conn->prepare("INSERT INTO users (username, password, is_admin) VALUES (?, ?, 0)");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        if ($stmt->affected_rows === 1) {
            $_SESSION['username'] = $username;
            $_SESSION['logged_in'] = true; // Помечаем пользователя как вошедшего в систему
            header("Location: index.php"); // Перенаправление на главную страницу
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Username already exists!";
    }
}
?>

<form action="register.php" method="post">
    <label>Username:</label><input type="text" name="username" required><br><br>
    <label>Password:</label><input type="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
