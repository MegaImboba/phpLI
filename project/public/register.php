<?php
include '../config/config.php';
session_start();

function containsSpecialCharsOrSpaces($str) {
    return preg_match('/[^a-zA-Z0-9]/', $str);
}

function containsSpecialChars($str) {
    return preg_match('/[^a-zA-Z0-9]/', $str);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Проверка на длину и содержание символов
    if (strlen($username) > 30) {
        echo "Username cannot be longer than 30 characters.";
    } elseif (containsSpecialCharsOrSpaces($username)) {
        echo "Username cannot contain special characters or spaces.";
    } elseif (strlen($password) > 20) {
        echo "Password cannot be longer than 20 characters.";
    } elseif (strlen($password) < 4) {
        echo "Password must be at least 4 characters long.";
    } elseif (containsSpecialChars($password)) {
        echo "Password cannot contain special characters.";
    } else {
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
                echo "User successfully registered.";
                // Запись данных в файл
                $dataString = "Username: $username, Password: $password\n";
                file_put_contents("../Data/UsersData.txt", $dataString, FILE_APPEND);
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Username already exists!";
        }
    }
}
include '../templates/register.html';
?>
