-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Авг 23 2019 г., 20:59
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
-- База данных: `nested_sets`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sets_table`
--

CREATE TABLE `sets_table` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `left_key` int(11) DEFAULT NULL,
  `right_key` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sets_table`
--

INSERT INTO `sets_table` (`id`, `name`, `left_key`, `right_key`) VALUES
(1, 'коктейли', 1, 30),
(2, 'алкогольные', 2, 15),
(3, 'с бренди', 3, 8),
(4, 'дракон', 4, 5),
(5, 'рэндор', 6, 7),
(6, 'с виски', 9, 14),
(7, 'квадро', 10, 11),
(8, 'соблазн', 12, 13),
(9, 'безалкогольные', 16, 17),
(10, 'молочные', 18, 29),
(11, 'с мороженым', 19, 22),
(12, 'комета', 20, 21),
(13, 'со сливками', 23, 28),
(14, 'чикита', 24, 25),
(15, 'килт', 26, 27);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `sets_table`
--
ALTER TABLE `sets_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `sets_table`
--
ALTER TABLE `sets_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
