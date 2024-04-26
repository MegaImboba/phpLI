<?php
include '../config/config.php';
session_start();
// Чтение всех фраз из файла
$filePath = '../templates/phrases.txt';
$phrases = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// Выбор случайной фразы, если файл не пустой
$randomPhrase = "No phrases available";
if (!empty($phrases)) {
    $randomPhrase = $phrases[rand(0, count($phrases) - 1)];
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>

	
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>MineAndCraft!</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
	@font-face {
    font-family: 'Minecraftia';
    src: url('../fonts/Minecraftia-Regular.ttf') format('truetype'); /* Путь к файлу шрифта */
    font-weight: normal;
    font-style: normal;
}
body {
    font-family: 'Minecraftia', monospace; /* Пиксельный шрифт для всей страницы */
    margin: 0;
    padding: 0;
    background-color: #3b3b3b; /* Темный фон, похожий на UI Minecraft */
    color: #ddd; /* Светлый текст для контраста */
    text-align: center;
}
        h1 {
            color: #333;
            background-color: #e3e3e3;
            padding: 20px;
            border-bottom: 4px solid #ccc;
        }
        a {
            color: #065535;
            text-decoration: none;
            font-weight: bold;
        }
		
.random-phrase {
    margin-top: 20px;
    font-size: 16px; /* Увеличенный размер текста для читаемости */
    color: #FFD700; /* Желтый цвет текста */
    background-color: #000000; /* Черный фон для фраз */
    padding: 20px;
    display: inline-block;
    border: 3px dashed #4CAF50; /* Пунктирная граница зеленого цвета Minecraft */
    box-shadow: 0 0 15px #4CAF50; /* Светящийся эффект */
}
        a:hover {
            text-decoration: underline;
        }
        video {
            width: 100%;
            height: auto;
        }
.mojang-games {
    font-size: 24px;
    color: #FFD700;
    font-family: 'Minecraftia', monospace;
    padding: 20px;
    margin-top: 20px;
    background-color: #1E1E1E;
    border: 3px solid #4CAF50;
    text-align: center;
    box-shadow: 0 0 10px #4CAF50;
}

.game-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    margin-top: 20px;
}

.game-box {
    display: flex;
    align-items: center;
    background: #333;
    border: 2px solid #555;
    padding: 10px;
    margin: 10px;
    width: 200px;
    box-shadow: 0 0 10px #555;
    color: white;
}

.game-box img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
}
        .welcome-message {
            font-size: 30px;
            color: #FFD700; /* Желтый цвет текста */
            background-color: #1E1E1E; /* Тёмный фон */
            padding: 20px;
            margin-top: 20px;
            border: 3px solid #4CAF50; /* Зелёная граница */
            box-shadow: 0 0 10px #4CAF50; /* Зелёный светящийся эффект */
        }


    </style>
</head>
<body>

    <?php
    // Показать кнопку "Login" или "Register", если пользователь не вошел в систему
    if (!isset($_SESSION['username'])) {
		echo '<h1>Добро пожаловать на неофициальный сайт по minecraft!</h1>';
		echo '<div class="random-phrase">' . htmlspecialchars($randomPhrase) . '</div>';
		echo "<div><video autoplay='true' preload='auto' muted='true' aria-label='Видео окружающего пространства' playsinline='true' preload='none' loop='true'>
            <source src='../Source/Realms.webm' type='video/webm'>
            Your browser does not support the video tag.
            </video></div>";
echo '<div class="mojang-games">
    Ознакомиться с играми Mojang:
</div>';

echo '<div class="game-container">';
$games = [
    'Minecraft' => 'minecraft_logo.png',
    'Minecraft Dungeons' => 'minecraft_dungeons_logo.png',
    'Minecraft Legends' => 'minecraft_legends_logo.png',
    'Minecraft Education Edition' => 'minecraft_education_logo.png'
];

foreach ($games as $game => $logo) {
    echo '<div class="game-box" data-game="'.strtolower(str_replace(' ', '', $game)).'">
        <img src="../Source/' . htmlspecialchars($logo) . '" alt="' . htmlspecialchars($game) . ' Logo">
        <span>' . htmlspecialchars($game) . '</span>
    </div>';
}
echo '</div>';
echo '   <div class="welcome-message">
        Мы рады видеть тебя в нашем сообществе! Присоединяйся!
    </div>';
        echo "<a href='login.php'>Login</a> | <a href='register.php'>Register</a>";
        
    } else {
		echo "<h1>Добро пожаловать на неофициальный форум по minecraft!</h1>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    $username = $_SESSION['username'];

    if (strlen($message) > 2000) {
        echo "<p>Message is too long. Maximum allowed characters is 2000.</p>";
    } else {
        // Валидация и очистка входных данных
        $message = htmlspecialchars($message);

        // Проверка лимита сообщений (20 сообщений в сутки)
        $stmt = $conn->prepare("SELECT COUNT(*) AS num_messages FROM messages WHERE username=? AND DATE(created_at) = CURDATE()");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
		$messages_result = $conn->query("SELECT username, message, created_at FROM messages ORDER BY created_at DESC");
		
		// Check for successful fetch
        if ($data['num_messages'] < 20) {
            $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $message);
            $stmt->execute();
            $stmt->close();
			  // Удаление дубликатов после каждой вставки
            $delete_duplicates = "DELETE n1 FROM messages n1, messages n2 WHERE n1.id > n2.id AND n1.username = n2.username AND n1.message = n2.message";
            $conn->query($delete_duplicates);
			
        } else {
            echo "<p>You have reached your daily limit of 20 messages.</p>";
        }
    }
}
		}
    
    ?>
<script>
let currentVideoPlayer = null; // Хранит текущий видеоплеер

document.querySelectorAll('.game-box').forEach(box => {
    box.addEventListener('click', function() {
        var game = this.getAttribute('data-game');
        fetch('getRandomVideo.php?game=' + game)
            .then(response => response.json())
            .then(data => {
                if (currentVideoPlayer) {
                    // Удаляем текущий видеоплеер, если он существует
                    currentVideoPlayer.remove();
                }

                if (data.video) {
                    // Создаем новый видеоплеер и добавляем его на страницу
                    currentVideoPlayer = document.createElement('video');
                    currentVideoPlayer.src = data.video;
                    currentVideoPlayer.controls = true;
                    currentVideoPlayer.autoplay = true;
                    document.body.appendChild(currentVideoPlayer);
                } else {
                    alert(data.error);
                }
            });
    });
});
</script>
   <?php if (isset($_SESSION['username'])) : ?>
        <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <a href='logout.php'>Logout</a>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            echo " | <a href='admin.php'>Admin Page</a>";
        } ?>
        <h2>Post a Message</h2>
        <form method="post" action="">
            <textarea name="message" required maxlength="2000"></textarea><br>
            <button type="submit">Send Message</button>
        </form>

        <h2>Messages</h2>
        <?php if ($messages_result): ?>
            <?php while($row = $messages_result->fetch_assoc()): ?>
                <p><strong><?php echo htmlspecialchars($row['username']); ?>:</strong> <?php echo htmlspecialchars($row['message']); ?> <i>on <?php echo $row['created_at']; ?></i></p>
            <?php endwhile; ?>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>

