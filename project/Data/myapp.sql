-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 26 2024 г., 13:10
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `myapp`
--

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `username`, `message`, `created_at`) VALUES
(1, 'admin123', '11231241244125', '2024-04-26 10:24:49'),
(8, 'admin123', '1245', '2024-04-26 10:26:07'),
(9, 'admin123', '126', '2024-04-26 10:26:35'),
(10, 'admin123', '1636163', '2024-04-26 10:26:37'),
(11, 'admin123', '136163163', '2024-04-26 10:26:38'),
(12, 'admin123', '1236362112636312', '2024-04-26 10:26:44'),
(13, 'admin123', '1236', '2024-04-26 10:26:46'),
(15, 'admin123', '123', '2024-04-26 10:26:47'),
(22, 'admin123', '12345', '2024-04-26 10:41:08'),
(26, 'admin123', '&lt;script&gt;console.log(&#039;Hello World&#039;);&lt;/script&gt;', '2024-04-26 10:48:06'),
(28, 'admin123', 'console.log(&#039;Hello World&#039;);', '2024-04-26 10:48:18'),
(32, 'admin123', '&#039;; DROP TABLE users;--', '2024-04-26 10:49:41'),
(33, 'admin123', '123122', '2024-04-26 10:56:17');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(3, 'admin1', '$2y$10$d0PgN3gvR1TxgXteIENDne.H6HAr6P.smrwXa2TbKlV9Iq14ikbvK', 1),
(6, 'admin123', '$2y$10$Xgdmsa1ya7b84uK.HkKLjO1rmitcFd97mXgvGG/Oeb/I/XO.O5cK6', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
