-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 30 2023 г., 18:02
-- Версия сервера: 5.6.38-log
-- Версия PHP: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `ex-test-pa-app`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Opers`
--

CREATE TABLE `Opers` (
  `oID` int(11) NOT NULL,
  `ouID` int(11) NOT NULL,
  `orID` int(11) NOT NULL,
  `ocID` int(11) NOT NULL,
  `oSum` decimal(13,6) NOT NULL DEFAULT '0.000000',
  `oState` int(1) NOT NULL DEFAULT '0',
  `oParams` text,
  `oOrder` varchar(120) NOT NULL,
  `oCTS` bigint(14) NOT NULL,
  `oUTS` bigint(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Opers`
--

INSERT INTO `Opers` (`oID`, `ouID`, `orID`, `ocID`, `oSum`, `oState`, `oParams`, `oOrder`, `oCTS`, `oUTS`) VALUES
(4, 7, 10, 1, '2898.000000', 3, 'a:3:{s:2:\"id\";s:36:\"51858812-8013-0b1f-5129-61246a7184c7\";s:9:\"errorCode\";s:1:\"0\";s:3:\"url\";s:109:\"https://3dsec.sberbank.ru/payment/merchants/test/payment_ru.html?mdOrder=51858812-8013-0b1f-5129-61246a7184c7\";}', '1215151241', 20230330142926, NULL),
(5, 8, 11, 1, '828.000000', 3, 'a:3:{s:2:\"id\";s:36:\"51858812-8013-0b1f-5129-61246a7184c7\";s:9:\"errorCode\";s:1:\"0\";s:3:\"url\";s:109:\"https://3dsec.sberbank.ru/payment/merchants/test/payment_ru.html?mdOrder=51858812-8013-0b1f-5129-61246a7184c7\";}', '1680188520', 20230330150157, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `OrderClients`
--

CREATE TABLE `OrderClients` (
  `clientId` int(11) NOT NULL,
  `clientFillName` varchar(90) NOT NULL,
  `clientHash` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `OrderClients`
--

INSERT INTO `OrderClients` (`clientId`, `clientFillName`, `clientHash`) VALUES
(2, '$eg', '411438f92b24c840081ab350d2260cb6'),
(3, 'fg43rb254hrwe', 'eb378b6fa9d16e0221962d6eaee74cf0'),
(4, 'd', '8277e0910d750195b448797616e091ad'),
(5, '4411', 'e243aa93e6b6e031797f86d0858f5e40'),
(6, 'Ege', '9689046aad07ee0307506fb6ccdad720'),
(7, 'Etgrw qefwqef', '391f19a8f1664bf18e18ba0588dedb43'),
(8, '24124', 'bab5a177611b396bd0a930cafb6b1c54');

-- --------------------------------------------------------

--
-- Структура таблицы `Orders`
--

CREATE TABLE `Orders` (
  `rID` int(11) NOT NULL,
  `ruID` int(11) NOT NULL,
  `rpID` int(11) NOT NULL,
  `rGroup` int(11) NOT NULL DEFAULT '0',
  `rCount` int(11) NOT NULL,
  `rSum` decimal(13,6) NOT NULL DEFAULT '1.000000',
  `rCTS` bigint(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Orders`
--

INSERT INTO `Orders` (`rID`, `ruID`, `rpID`, `rGroup`, `rCount`, `rSum`, `rCTS`) VALUES
(3, 3, 2, 0, 4, '101.000000', 20230329184750),
(4, 3, 1, 0, 9, '100.000000', 20230329184827),
(6, 3, 1, 0, 6, '100.000000', 20230330104847),
(7, 2, 3, 0, 5, '414.000000', 20230330113422),
(8, 5, 4, 0, 4, '99.000000', 20230330133018),
(9, 6, 3, 0, 5, '414.000000', 20230330142642),
(10, 7, 3, 0, 7, '414.000000', 20230330142925),
(11, 8, 3, 0, 2, '414.000000', 20230330150156);

-- --------------------------------------------------------

--
-- Структура таблицы `Products`
--

CREATE TABLE `Products` (
  `pID` int(11) NOT NULL,
  `pName` varchar(90) NOT NULL,
  `pDescr` text NOT NULL,
  `pSum` decimal(13,9) NOT NULL,
  `pAvailable` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `Products`
--

INSERT INTO `Products` (`pID`, `pName`, `pDescr`, `pSum`, `pAvailable`) VALUES
(1, 'Чайник', '', '100.000000000', -1),
(2, 'Стол', 'Стол', '101.000000000', -1),
(3, 'Ложка', '', '414.000000000', -1),
(4, 'Чашка', '', '99.000000000', -1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Opers`
--
ALTER TABLE `Opers`
  ADD PRIMARY KEY (`oID`),
  ADD UNIQUE KEY `orID` (`orID`);

--
-- Индексы таблицы `OrderClients`
--
ALTER TABLE `OrderClients`
  ADD PRIMARY KEY (`clientId`),
  ADD UNIQUE KEY `clientHash` (`clientHash`);

--
-- Индексы таблицы `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`rID`);

--
-- Индексы таблицы `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`pID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Opers`
--
ALTER TABLE `Opers`
  MODIFY `oID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `OrderClients`
--
ALTER TABLE `OrderClients`
  MODIFY `clientId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `Orders`
--
ALTER TABLE `Orders`
  MODIFY `rID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `Products`
--
ALTER TABLE `Products`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
