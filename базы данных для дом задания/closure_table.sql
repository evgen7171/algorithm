-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Авг 23 2019 г., 20:58
-- Версия сервера: 5.6.43-log
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `closure_table`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Каталог'),
(2, 'Одежда'),
(3, 'Продукты'),
(4, 'Верхняя одежда'),
(5, 'Молочные продукты'),
(6, 'Колбасы'),
(7, 'Обувь'),
(8, 'Открытая обувь'),
(9, 'Закрытая обувь'),
(10, 'Овощи'),
(11, 'Фрукты'),
(12, 'Белье'),
(13, 'Штаны');

-- --------------------------------------------------------

--
-- Структура таблицы `categories_links`
--

CREATE TABLE `categories_links` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `child_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories_links`
--

INSERT INTO `categories_links` (`id`, `parent_id`, `child_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(6, 2, 2),
(7, 2, 4),
(8, 3, 3),
(9, 3, 5),
(10, 3, 6),
(11, 2, 7),
(12, 7, 8),
(13, 7, 9),
(14, 3, 10),
(15, 3, 11),
(16, 2, 12),
(17, 2, 13);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories_links`
--
ALTER TABLE `categories_links`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `categories_links`
--
ALTER TABLE `categories_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
