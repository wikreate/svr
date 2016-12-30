-- phpMyAdmin SQL Dump
-- version 4.0.10
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 30 2016 г., 21:45
-- Версия сервера: 5.1.73-community-log
-- Версия PHP: 5.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `survey`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `session_hash` varchar(255) NOT NULL,
  `last_update_password` int(11) NOT NULL,
  `last_visit` int(11) NOT NULL,
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  `active` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Дамп данных таблицы `admin_users`
--

INSERT INTO `admin_users` (`id`, `id_role`, `parent_id`, `login`, `password`, `session_hash`, `last_update_password`, `last_visit`, `page_up`, `delete`, `active`) VALUES
(19, 1, 0, 'super', 'c2cc71976db0760a83466e8e8baadd64', '280d623ee60b118e67a987d9e04993c2', 1482615578, 1483111164, 0, '0', '1'),
(20, 2, 19, 'admin', 'fe01ce2a7fbac8fafaed7c982a04e229', '893859d42544a9bfe4bc6146089158b0', 1480538331, 1481101055, 0, '0', '1'),
(21, 3, 19, 'demo', '0e444615215d8eaf41b647260ce456e6', '2d18baa0d72aac591ddf221827940c27', 1481050318, 1481050327, 0, '0', '1'),
(22, 3, 19, 'sdasdasd', '9f9e2d409b5756fe707fd9d407048128', '', 1481102511, 0, 0, '1', '1'),
(23, 3, 19, 'test', '75361aa2950f87a624b985608f6ba6bb', '', 0, 0, 0, '0', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `chapter`
--

CREATE TABLE IF NOT EXISTS `chapter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_interview` int(11) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

--
-- Дамп данных таблицы `chapter`
--

INSERT INTO `chapter` (`id`, `id_interview`, `view`, `page_up`, `delete`) VALUES
(11, 17, '1', 3, '1'),
(12, 17, '1', 2, '0'),
(13, 17, '1', 4, '0'),
(14, 17, '1', 1, '0'),
(15, 17, '1', 0, '0'),
(16, 17, '1', 0, '0'),
(17, 18, '1', 0, '0'),
(18, 27, '1', 0, '0'),
(19, 27, '1', 0, '0'),
(20, 28, '1', 0, '0'),
(21, 28, '1', 0, '0'),
(22, 29, '1', 0, '0'),
(23, 29, '1', 0, '0'),
(24, 30, '1', 0, '0'),
(25, 30, '1', 0, '0'),
(26, 31, '1', 0, '0'),
(27, 31, '1', 0, '0'),
(28, 12, '1', 0, '0'),
(29, 32, '1', 0, '0'),
(30, 33, '1', 0, '0'),
(31, 34, '1', 0, '0'),
(32, 35, '1', 0, '0'),
(33, 36, '1', 0, '0'),
(34, 37, '1', 0, '0'),
(35, 38, '1', 0, '0'),
(36, 39, '1', 0, '0'),
(37, 40, '1', 0, '0'),
(38, 41, '1', 0, '0'),
(39, 42, '1', 0, '0'),
(40, 43, '1', 1, '0'),
(41, 44, '1', 1, '0'),
(42, 45, '1', 1, '0'),
(43, 46, '1', 1, '0'),
(44, 47, '1', 0, '0'),
(45, 48, '1', 0, '0'),
(46, 48, '1', 0, '1'),
(47, 48, '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `chapter_lang`
--

CREATE TABLE IF NOT EXISTS `chapter_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=376 ;

--
-- Дамп данных таблицы `chapter_lang`
--

INSERT INTO `chapter_lang` (`id`, `post_id`, `name`, `id_lang`, `delete`) VALUES
(322, 11, '1', 4, '0'),
(323, 11, '1', 3, '0'),
(324, 12, '1', 4, '0'),
(325, 12, '1', 3, '0'),
(326, 13, '1', 4, '0'),
(327, 13, '1', 3, '0'),
(330, 14, '1', 4, '0'),
(331, 14, '1', 5, '0'),
(334, 15, '1', 4, '0'),
(335, 15, '1', 5, '0'),
(336, 16, 'new chapter ru', 4, '0'),
(337, 16, 'new chapter de', 5, '0'),
(340, 17, 'new chapter ru', 4, '0'),
(341, 17, 'new chapter de', 5, '0'),
(342, 18, 'Chapter ru 1', 4, '0'),
(343, 18, 'Chapter ro 1', 3, '0'),
(344, 19, 'Chapter ru 2', 4, '0'),
(345, 19, 'Chapter ro 2', 3, '0'),
(346, 20, 'Chapter 1 ru', 4, '0'),
(347, 20, 'Chapter 1 ro', 3, '0'),
(348, 21, 'Chapter 2 ru', 4, '0'),
(349, 21, 'Chapter 2 ro', 3, '0'),
(350, 28, 'rewrewr', 3, '0'),
(351, 29, 'rewrewr', 3, '0'),
(352, 15, '1', 6, '0'),
(353, 30, 'rewrewr', 3, '0'),
(354, 31, 'rewrewr', 3, '0'),
(355, 32, 'rewrewr', 3, '0'),
(356, 33, 'rewrewr', 3, '0'),
(357, 34, 'rewrewr', 3, '0'),
(358, 35, 'rewrewr', 3, '0'),
(359, 36, 'rewrewr', 3, '0'),
(360, 37, 'rewrewr', 3, '0'),
(361, 38, 'rewrewr', 3, '0'),
(362, 39, 'rewrewr', 3, '0'),
(363, 40, 'rewrewr', 3, '0'),
(364, 41, 'rewrewr copy', 3, '0'),
(365, 42, 'rewrewr', 3, '0'),
(366, 43, 'rewrewr', 3, '0'),
(367, 44, 'chaprter', 2, '0'),
(369, 45, 'Ru chapter 1', 4, '0'),
(370, 45, 'En chapter 1', 2, '0'),
(371, 45, 'En chapter 1 test', 2, '1'),
(372, 46, 'Ru chapter 2', 4, '0'),
(373, 46, 'En chapter 2', 2, '0'),
(374, 47, 'Ru chapter 2', 4, '0'),
(375, 47, 'En chapter 2', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `chapter_question`
--

CREATE TABLE IF NOT EXISTS `chapter_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chapter` int(11) NOT NULL,
  `required` enum('0','1') NOT NULL DEFAULT '0',
  `max_choices` int(1) NOT NULL,
  `type` enum('1','2','3') NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Дамп данных таблицы `chapter_question`
--

INSERT INTO `chapter_question` (`id`, `id_chapter`, `required`, `max_choices`, `type`, `view`, `page_up`, `delete`) VALUES
(3, 12, '0', 0, '1', '1', 0, '0'),
(4, 13, '0', 0, '1', '1', 0, '0'),
(5, 14, '0', 0, '2', '1', 1, '0'),
(6, 14, '0', 0, '1', '1', 3, '0'),
(7, 14, '1', 0, '3', '1', 2, '0'),
(8, 15, '0', 0, '2', '1', 0, '0'),
(9, 14, '0', 0, '2', '1', 0, '0'),
(10, 17, '0', 0, '3', '1', 1, '0'),
(11, 17, '1', 0, '2', '1', 0, '0'),
(12, 18, '1', 0, '2', '1', 0, '0'),
(13, 20, '1', 0, '2', '1', 2, '0'),
(14, 20, '1', 0, '2', '1', 1, '0'),
(15, 29, '1', 0, '2', '1', 0, '0'),
(16, 35, '0', 0, '1', '1', 0, '0'),
(17, 36, '1', 0, '2', '1', 0, '0'),
(18, 37, '1', 0, '2', '1', 0, '0'),
(19, 38, '1', 0, '2', '1', 0, '0'),
(20, 39, '1', 0, '2', '1', 0, '0'),
(21, 28, '1', 0, '2', '1', 0, '0'),
(22, 40, '1', 0, '2', '1', 1, '0'),
(23, 41, '1', 0, '2', '1', 1, '0'),
(24, 42, '1', 0, '2', '1', 1, '0'),
(25, 43, '1', 0, '2', '1', 1, '0'),
(26, 44, '1', 0, '1', '1', 0, '0'),
(27, 45, '0', 0, '3', '1', 3, '0'),
(28, 45, '1', 2, '2', '1', 2, '0'),
(29, 45, '1', 0, '1', '1', 1, '0'),
(30, 46, '1', 0, '3', '1', 0, '0'),
(31, 46, '0', 444, '2', '1', 0, '0'),
(32, 47, '0', 0, '1', '1', 0, '0'),
(33, 47, '1', 0, '1', '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `chapter_question_lang`
--

CREATE TABLE IF NOT EXISTS `chapter_question_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=615 ;

--
-- Дамп данных таблицы `chapter_question_lang`
--

INSERT INTO `chapter_question_lang` (`id`, `post_id`, `question`, `id_lang`, `delete`) VALUES
(330, 12, 'Question 1 Chapter ru 1', 4, '0'),
(331, 12, 'Question 1 Chapter ro 1', 3, '0'),
(474, 3, '1', 4, '0'),
(475, 3, '1', 3, '0'),
(476, 3, '16', 4, '0'),
(477, 3, '16', 3, '0'),
(502, 4, '1', 4, '0'),
(503, 4, '1', 5, '0'),
(504, 4, '2', 4, '0'),
(505, 4, '2', 5, '0'),
(506, 5, '1', 4, '0'),
(507, 5, '1', 5, '0'),
(512, 6, '1', 4, '0'),
(513, 6, '1', 5, '0'),
(514, 6, '2', 4, '0'),
(515, 6, '2', 5, '0'),
(520, 7, '1', 4, '0'),
(521, 7, '1', 5, '0'),
(522, 14, 'Question Chapter 1 ru', 4, '0'),
(523, 14, '1', 5, '0'),
(532, 9, '1', 4, '0'),
(533, 9, '1', 5, '0'),
(552, 8, '23', 4, '0'),
(553, 8, '23', 5, '0'),
(554, 8, '1', 4, '0'),
(555, 8, '1', 5, '0'),
(564, 11, 'q ru 1', 4, '0'),
(565, 11, 'q de 1', 5, '0'),
(566, 10, 'new question ru', 4, '0'),
(567, 10, 'new question de', 5, '0'),
(568, 13, 'Question Chapter 1 ru', 4, '0'),
(569, 13, 'Question Chapter 1 ro', 3, '0'),
(570, 14, 'Question Chapter 1 ro', 3, '0'),
(571, 15, '1', 4, '0'),
(572, 15, '16', 3, '0'),
(573, 15, '16', 4, '0'),
(574, 15, '16', 3, '0'),
(575, 16, '1', 4, '0'),
(576, 16, '1', 3, '0'),
(577, 16, '16', 4, '0'),
(578, 16, '16', 3, '0'),
(579, 17, '1', 4, '0'),
(580, 17, '16', 3, '0'),
(581, 17, '16', 4, '0'),
(582, 17, '16', 3, '0'),
(583, 18, '1', 4, '0'),
(584, 18, '16', 3, '0'),
(585, 18, '16', 4, '0'),
(586, 18, '16', 3, '0'),
(587, 19, '1', 4, '0'),
(588, 19, '16', 3, '0'),
(589, 19, '16', 4, '0'),
(590, 19, '16', 3, '0'),
(591, 20, '1', 4, '0'),
(592, 20, '16', 3, '0'),
(593, 20, '16', 4, '0'),
(594, 20, '16', 3, '0'),
(595, 21, 'Какая температура на солнце?', 3, '0'),
(596, 22, 'Какая температура на солнце?', 3, '0'),
(597, 23, 'Какая температура на солнце?', 3, '0'),
(598, 24, 'Какая температура на солнце?', 3, '0'),
(599, 25, 'Какая температура на солнце?', 3, '0'),
(600, 26, 'Есть ли жизнь на марсе?', 2, '0'),
(601, 27, 'Question 1 ru', 4, '0'),
(602, 27, 'Question 1 en', 2, '0'),
(603, 28, 'Question 1 ru', 4, '0'),
(604, 28, 'Question 2 en', 2, '0'),
(605, 29, ' Question 3 ru', 4, '0'),
(606, 29, ' Question 3 en', 2, '0'),
(607, 30, 'test', 4, '0'),
(608, 30, '', 2, '0'),
(609, 31, 'sadasdasd', 4, '0'),
(610, 31, '', 2, '0'),
(611, 32, 'Стиль управления Вашего прямого начальника оказывает влияние на Вашу работу?', 4, '0'),
(612, 32, '', 2, '0'),
(613, 33, 'Вы довольны стилем управления начальников организации, где Вы работаете?', 4, '0'),
(614, 33, '', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `chapter_status`
--

CREATE TABLE IF NOT EXISTS `chapter_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_chapter` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_interview` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=82 ;

--
-- Дамп данных таблицы `chapter_status`
--

INSERT INTO `chapter_status` (`id`, `id_chapter`, `id_user`, `id_interview`, `status`, `date`) VALUES
(80, 47, 57, 48, '1', 1483119789),
(81, 45, 57, 48, '0', 1483119795);

-- --------------------------------------------------------

--
-- Структура таблицы `choice`
--

CREATE TABLE IF NOT EXISTS `choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

--
-- Дамп данных таблицы `choice`
--

INSERT INTO `choice` (`id`, `id_question`, `view`, `page_up`, `delete`) VALUES
(3, 3, '1', 1, '1'),
(4, 3, '1', 5, '1'),
(9, 3, '1', 0, '1'),
(10, 3, '1', 0, '1'),
(11, 3, '1', 4, '1'),
(12, 3, '1', 0, '1'),
(13, 3, '1', 0, '1'),
(14, 3, '1', 0, '1'),
(15, 3, '1', 3, '1'),
(16, 3, '1', 2, '1'),
(17, 3, '1', 0, '1'),
(18, 3, '1', 0, '1'),
(19, 5, '1', 0, '0'),
(20, 5, '1', 0, '0'),
(21, 8, '1', 3, '1'),
(22, 8, '1', 6, '1'),
(23, 8, '1', 2, '1'),
(24, 8, '1', 5, '1'),
(25, 9, '1', 0, '0'),
(26, 9, '1', 0, '0'),
(27, 8, '1', 4, '1'),
(28, 8, '1', 1, '1'),
(29, 8, '1', 0, '0'),
(30, 10, '1', 0, '1'),
(31, 10, '1', 0, '1'),
(32, 10, '1', 0, '1'),
(33, 10, '1', 0, '1'),
(34, 11, '1', 0, '0'),
(35, 11, '1', 0, '0'),
(36, 12, '1', 0, '0'),
(37, 12, '1', 0, '0'),
(38, 13, '1', 0, '0'),
(39, 13, '1', 0, '0'),
(40, 14, '1', 0, '0'),
(41, 14, '1', 0, '0'),
(42, 15, '1', 0, '0'),
(43, 15, '1', 0, '0'),
(44, 18, '1', 0, '0'),
(45, 18, '1', 0, '0'),
(46, 19, '1', 0, '0'),
(47, 19, '1', 0, '0'),
(48, 20, '1', 0, '0'),
(49, 20, '1', 0, '0'),
(50, 21, '1', 1, '1'),
(51, 21, '1', 4, '1'),
(52, 21, '1', 3, '1'),
(53, 21, '1', 2, '1'),
(54, 21, '1', 0, '1'),
(55, 21, '0', 0, '1'),
(56, 21, '1', 0, '1'),
(57, 21, '1', 0, '1'),
(58, 21, '0', 0, '1'),
(59, 21, '1', 0, '1'),
(60, 21, '1', 0, '1'),
(61, 21, '1', 0, '1'),
(62, 21, '1', 0, '1'),
(63, 21, '1', 1, '0'),
(64, 21, '1', 0, '1'),
(65, 21, '1', 2, '0'),
(66, 22, '1', 1, '0'),
(67, 22, '1', 2, '0'),
(68, 23, '1', 1, '0'),
(69, 23, '1', 2, '0'),
(70, 24, '1', 1, '0'),
(71, 24, '1', 2, '0'),
(72, 25, '1', 1, '0'),
(73, 25, '1', 2, '0'),
(74, 26, '0', 1, '0'),
(75, 26, '1', 2, '0'),
(76, 26, '0', 3, '0'),
(77, 28, '1', 0, '0'),
(78, 28, '1', 0, '0'),
(79, 28, '1', 0, '0'),
(80, 29, '1', 0, '0'),
(81, 29, '1', 0, '0'),
(82, 29, '1', 0, '0'),
(83, 32, '1', 0, '0'),
(84, 32, '1', 0, '0'),
(85, 32, '1', 0, '0'),
(86, 33, '1', 0, '0'),
(87, 33, '1', 0, '0'),
(88, 33, '1', 0, '0'),
(89, 33, '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `choice_lang`
--

CREATE TABLE IF NOT EXISTS `choice_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=459 ;

--
-- Дамп данных таблицы `choice_lang`
--

INSERT INTO `choice_lang` (`id`, `post_id`, `name`, `id_lang`, `delete`) VALUES
(326, 3, '1', 3, '0'),
(327, 4, '1', 3, '0'),
(329, 3, '1', 4, '0'),
(330, 4, '1', 4, '0'),
(336, 9, '1', 3, '0'),
(337, 9, '1', 4, '0'),
(338, 10, '1', 3, '0'),
(339, 10, '1', 4, '0'),
(340, 11, '1', 3, '0'),
(341, 11, '1', 4, '0'),
(342, 12, '1', 3, '0'),
(343, 12, '1', 4, '0'),
(344, 13, '1', 3, '0'),
(345, 13, '1', 4, '0'),
(346, 14, '1', 3, '0'),
(347, 14, '1', 4, '0'),
(348, 15, '1', 3, '0'),
(349, 15, '1', 4, '0'),
(350, 16, '1', 3, '0'),
(351, 16, '1', 4, '0'),
(352, 17, '1', 3, '0'),
(353, 17, '1', 4, '0'),
(354, 18, '1', 3, '0'),
(355, 18, '1', 4, '0'),
(356, 19, '1', 4, '0'),
(357, 19, '1', 5, '0'),
(358, 20, '1', 4, '0'),
(359, 20, '1', 5, '0'),
(360, 21, '1', 4, '0'),
(361, 21, '1', 5, '0'),
(362, 22, '1', 4, '0'),
(363, 22, '1', 5, '0'),
(364, 23, '1', 4, '0'),
(365, 23, '1', 5, '0'),
(366, 24, '1', 4, '0'),
(367, 24, '1', 5, '0'),
(368, 25, '1', 4, '0'),
(369, 25, '1', 5, '0'),
(370, 26, '1', 4, '0'),
(371, 26, '1', 5, '0'),
(372, 27, '1', 4, '0'),
(373, 27, '1', 5, '0'),
(374, 28, '1', 4, '0'),
(375, 28, '1', 5, '0'),
(376, 29, '1', 4, '0'),
(377, 29, '1', 5, '0'),
(378, 30, '1', 5, '0'),
(379, 31, '2', 5, '0'),
(380, 32, '3 edit', 5, '0'),
(381, 33, '4', 5, '0'),
(382, 34, '1 ru', 4, '0'),
(383, 34, '1 de', 5, '0'),
(384, 35, '2 ru', 4, '0'),
(385, 35, '2 de', 5, '0'),
(386, 36, '1 ro', 3, '0'),
(387, 36, '1 ru', 4, '0'),
(388, 37, '2 ro', 3, '0'),
(389, 37, '2 ru', 4, '0'),
(390, 38, '1 ro', 3, '0'),
(391, 38, '1 ru', 4, '0'),
(392, 39, '2 ro', 3, '0'),
(393, 39, '2 ru', 4, '0'),
(394, 40, '1 ro', 3, '0'),
(395, 40, '1 ru', 4, '0'),
(396, 41, '2 ro', 3, '0'),
(397, 41, '2 ru', 4, '0'),
(398, 42, '1 ro', 3, '0'),
(399, 43, '2 ro', 3, '0'),
(400, 44, '1 ro', 3, '0'),
(401, 45, '2 ro', 3, '0'),
(402, 46, '1 ro', 3, '0'),
(403, 47, '2 ro', 3, '0'),
(404, 48, '1 ro', 3, '0'),
(405, 49, '2 ro', 3, '0'),
(406, 50, '60 000', 3, '0'),
(407, 51, '100000', 3, '0'),
(408, 52, '27 000 000', 3, '0'),
(409, 53, '4', 3, '0'),
(410, 54, '4000', 3, '0'),
(411, 55, '2133', 3, '0'),
(412, 56, '27000000', 3, '0'),
(413, 57, '1', 3, '0'),
(414, 58, '2', 3, '0'),
(415, 59, '3', 3, '0'),
(416, 60, '1', 3, '0'),
(417, 61, '3', 3, '0'),
(418, 62, '4', 3, '0'),
(419, 63, '1', 3, '0'),
(420, 64, '3', 3, '0'),
(421, 65, '3', 3, '0'),
(422, 66, '1', 3, '0'),
(423, 67, '3', 3, '0'),
(424, 68, '1', 3, '0'),
(425, 69, '3', 3, '0'),
(426, 70, '1', 3, '0'),
(427, 71, '3', 3, '0'),
(428, 72, '1', 3, '0'),
(429, 73, '3', 3, '0'),
(430, 74, '1', 2, '0'),
(431, 75, '2', 2, '0'),
(432, 76, '3', 2, '0'),
(433, 77, 'Multiple choice 1 en', 2, '0'),
(434, 77, 'Multiple choice 1 ru', 4, '0'),
(435, 78, 'Multiple choice 2 en', 2, '0'),
(436, 78, 'Multiple choice 2 ru', 4, '0'),
(437, 79, 'Multiple choice 3 en', 2, '0'),
(438, 79, 'Multiple choice 3 ru ', 4, '0'),
(439, 80, 'One answer en 1', 2, '0'),
(440, 80, 'One answer ru 1', 4, '0'),
(441, 81, 'One answer en 2', 2, '0'),
(442, 81, 'One answer ru 2', 4, '0'),
(443, 82, 'One answer en 3', 2, '0'),
(444, 82, 'One answer ru 3', 4, '0'),
(445, 83, '', 2, '0'),
(446, 83, 'Да', 4, '0'),
(447, 84, '', 2, '0'),
(448, 84, 'Не знаю', 4, '0'),
(449, 85, '', 2, '0'),
(450, 85, 'Нет', 4, '0'),
(451, 86, '', 2, '0'),
(452, 86, 'Доволен/льна', 4, '0'),
(453, 87, '', 2, '0'),
(454, 87, 'Скорее доволен/льна', 4, '0'),
(455, 88, '', 2, '0'),
(456, 88, 'Ни то, ни другое', 4, '0'),
(457, 89, '', 2, '0'),
(458, 89, 'Недоволен/льна', 4, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `constants`
--

CREATE TABLE IF NOT EXISTS `constants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `editor` enum('0','1') NOT NULL DEFAULT '0',
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `constants`
--

INSERT INTO `constants` (`id`, `name`, `description`, `editor`, `view`, `page_up`) VALUES
(2, 'EMAIL', 'Email', '0', '1', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `constants_value`
--

CREATE TABLE IF NOT EXISTS `constants_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_lang` int(11) NOT NULL,
  `id_const` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=429 ;

--
-- Дамп данных таблицы `constants_value`
--

INSERT INTO `constants_value` (`id`, `id_lang`, `id_const`, `value`) VALUES
(424, 6, 2, 'fleancu.daniel@mail.ru fr'),
(425, 4, 2, 'info@ilab.md'),
(426, 5, 2, 'fleancu.daniel@mail.ru de'),
(427, 3, 2, 'fleancu.daniel@mail.ru ro'),
(428, 2, 2, 'info@ilab.md');

-- --------------------------------------------------------

--
-- Структура таблицы `emails_list`
--

CREATE TABLE IF NOT EXISTS `emails_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Дамп данных таблицы `emails_list`
--

INSERT INTO `emails_list` (`id`, `id_project`, `email`, `view`, `page_up`, `delete`) VALUES
(36, 35, 'CA,,', '1', 0, '0'),
(37, 35, 'Cw,,', '1', 0, '0'),
(38, 35, 'Cg,,', '1', 0, '0'),
(39, 35, 'DQ,,', '1', 0, '0'),
(40, 35, 'DA,,', '1', 0, '0'),
(41, 30, 'CA,,', '1', 0, '0'),
(42, 30, 'Cw,,', '1', 0, '0'),
(43, 30, 'Cg,,', '1', 0, '0'),
(44, 30, 'DQ,,', '1', 0, '1'),
(45, 30, 'DA,,', '1', 0, '0'),
(46, 30, 'DQ,,', '1', 0, '0'),
(47, 39, 'UFhSDXBeXVRQSl9X', '1', 0, '0'),
(48, 39, 'TVNHFnBaUFxeSlFcVA,,', '1', 0, '0'),
(49, 39, 'TVNHFgJ3XFRbCBxQVls,', '1', 0, '1'),
(50, 39, 'CHZZA1lbH1ZdCQ,,', '1', 0, '0'),
(51, 39, 'C3ZZA1lbH1ZdCQ,,', '1', 0, '0'),
(52, 39, 'CnZZA1lbH1ZdCQ,,', '1', 0, '0'),
(53, 39, 'DHZZA1lbH1ZdCQ,,', '1', 0, '0'),
(54, 39, 'D3ZZA1lbH1ZdCQ,,', '1', 0, '0'),
(55, 39, 'DkJREUR3XFRbCBxQVls,', '1', 0, '0'),
(56, 31, 'X1pRA15URBtWBVxaXFp0D1FeXRtAEQ,,', '1', 0, '0'),
(57, 38, 'X1pRA15URBtWBVxaXFp0BV1WWFkcB11e', '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL DEFAULT '0',
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Дамп данных таблицы `faq`
--

INSERT INTO `faq` (`id`, `id_category`, `view`, `page_up`, `delete`) VALUES
(46, 38, '1', 0, '0'),
(47, 39, '1', 0, '0'),
(48, 40, '1', 0, '0'),
(49, 39, '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `faq_categories`
--

CREATE TABLE IF NOT EXISTS `faq_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Дамп данных таблицы `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `parent_id`, `view`, `page_up`, `delete`) VALUES
(38, 0, '1', 2, '0'),
(39, 0, '1', 1, '0'),
(40, 0, '1', 3, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `faq_categories_lang`
--

CREATE TABLE IF NOT EXISTS `faq_categories_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=247 ;

--
-- Дамп данных таблицы `faq_categories_lang`
--

INSERT INTO `faq_categories_lang` (`id`, `post_id`, `name`, `id_lang`, `delete`) VALUES
(232, 38, 'Cat 1', 6, '0'),
(233, 38, 'Экономика', 4, '0'),
(234, 38, '', 5, '0'),
(235, 38, '', 3, '0'),
(236, 38, 'Economy', 2, '0'),
(237, 39, '', 6, '0'),
(238, 39, 'Происшествия', 4, '0'),
(239, 39, '', 5, '0'),
(240, 39, '', 3, '0'),
(241, 39, 'Incidents', 2, '0'),
(242, 40, 'Cat 3', 6, '0'),
(243, 40, 'Политика', 4, '0'),
(244, 40, '', 5, '0'),
(245, 40, '', 3, '0'),
(246, 40, 'Policy', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `faq_lang`
--

CREATE TABLE IF NOT EXISTS `faq_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `text` text NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=287 ;

--
-- Дамп данных таблицы `faq_lang`
--

INSERT INTO `faq_lang` (`id`, `post_id`, `name`, `description`, `text`, `id_lang`, `delete`) VALUES
(279, 46, 'Какую пенсию Вы считаете достойной и сколько готовы ежемесячно отдавать с зарплаты в ПФ для ее обеспечения?', '', 'Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.&lt;br /&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.', 4, '0'),
(280, 46, '', '', '', 2, '0'),
(281, 47, 'Как вы считаете, какая субкультура сейчас самая популярная среди подростков?', '', 'Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.&lt;br /&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.', 4, '0'),
(282, 47, '', '', '', 2, '0'),
(283, 48, 'Куда вы поедете отдыхать этим летом?', '', 'Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.&lt;br /&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.', 4, '0'),
(284, 48, '', '', '', 2, '0'),
(285, 49, 'test', '', 'sadsad', 4, '0'),
(286, 49, '', '', '', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `interview`
--

CREATE TABLE IF NOT EXISTS `interview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL,
  `langs` varchar(255) NOT NULL,
  `date_send_welcome` int(11) NOT NULL,
  `date_start` int(11) NOT NULL,
  `date_end` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `activated` enum('0','1') DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `delete` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Дамп данных таблицы `interview`
--

INSERT INTO `interview` (`id`, `id_project`, `langs`, `date_send_welcome`, `date_start`, `date_end`, `status`, `activated`, `image`, `delete`) VALUES
(48, 31, '', 1481583600, 1480460400, 1483225200, 1, '1', '', '0');

-- --------------------------------------------------------

--
-- Структура таблицы `interview_lang`
--

CREATE TABLE IF NOT EXISTS `interview_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `welcome_text` text NOT NULL,
  `info_text` text NOT NULL,
  `deactivated_message` text NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=487 ;

--
-- Дамп данных таблицы `interview_lang`
--

INSERT INTO `interview_lang` (`id`, `post_id`, `name`, `description`, `welcome_text`, `info_text`, `deactivated_message`, `id_lang`, `delete`) VALUES
(440, 12, 'Name ro', '', '', '', 'bhkh', 3, '0'),
(446, 17, 'name ru 1 edit', '', '', '', 'rewr', 4, '0'),
(447, 17, 'name ru 1 edit', '', '', '', 'rewr', 4, '0'),
(448, 17, 'name ru 1 edit', '', '', '', 'rewr', 4, '0'),
(449, 17, 'name ru 1 edit', '', '', '', 'rewr', 4, '0'),
(450, 17, 'name de 1', '', '', '', 'rwer', 5, '0'),
(451, 17, 'name fr', '', '', '', 'rewrwer', 6, '0'),
(452, 26, 'name fr', '', '', '', '', 6, '0'),
(453, 27, 'name fr', '', '', '', '', 6, '0'),
(454, 27, 'name copy ru', 'Description ru', 'Welcome text ru', 'Info text ru', '', 4, '0'),
(455, 27, 'name copy ro', 'Description ro', 'Welcome text ro', 'Info text ro', '', 3, '0'),
(456, 27, 'name copy en', '', '', '', '', 2, '0'),
(457, 28, 'name copy en', '', '', '', '', 2, '0'),
(458, 28, 'name ru', '', '', 'Info text ru', '', 4, '0'),
(459, 28, 'name ro', 'Description ro', '', 'Info text ro', '', 3, '0'),
(460, 29, 'name copy en', '', '', '', '', 2, '0'),
(461, 29, 'name ru', '', '', 'Info text ru', '', 4, '0'),
(462, 29, 'name ro', 'Description ro', '', 'Info text ro', '', 3, '0'),
(463, 30, 'name copy en', '', '', '', '', 2, '0'),
(464, 30, 'name ru', '', '', 'Info text ru', '', 4, '0'),
(465, 30, 'name ro', 'Description ro', '', 'Info text ro', '', 3, '0'),
(466, 31, 'name copy en', '', '', '', '', 2, '0'),
(467, 31, 'name ru', '', '', 'Info text ru', '', 4, '0'),
(468, 31, 'name ro', 'Description ro', '', 'Info text ro', '', 3, '0'),
(469, 32, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(470, 33, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(471, 34, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(472, 35, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(473, 36, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(474, 37, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(475, 38, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(476, 39, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(477, 40, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(478, 41, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(479, 42, 'Name ro', '', '', '', 'фяыфвыффыв', 3, '0'),
(480, 43, 'Name ro', '', '', '', 'bhkh', 3, '0'),
(481, 44, 'Name ro', '', '', '', 'bhkh', 3, '0'),
(482, 45, 'Name ro copy', '', '', '', 'bhkh', 3, '0'),
(483, 46, 'Name ro copy copy', '', '', '', 'bhkh', 3, '0'),
(484, 47, 'asdadad', 'asd', 'asdasd', 'asdasd', '', 2, '0'),
(485, 48, 'New survey', 'Description', 'Welcome text! Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus.', 'Info text!', '', 2, '0'),
(486, 48, 'name survet', '', '', '', '', 4, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `interview_select_lang`
--

CREATE TABLE IF NOT EXISTS `interview_select_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_interview` int(11) NOT NULL,
  `id_lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Дамп данных таблицы `interview_select_lang`
--

INSERT INTO `interview_select_lang` (`id`, `id_interview`, `id_lang`) VALUES
(13, 48, 4),
(14, 48, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `interview_status`
--

CREATE TABLE IF NOT EXISTS `interview_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_status` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `interview_status`
--

INSERT INTO `interview_status` (`id`, `id_status`, `name`, `view`, `page_up`, `delete`) VALUES
(1, 0, 'Creating', '1', 0, '0'),
(2, 0, 'In progress', '1', 0, '0'),
(3, 0, 'Closed', '1', 0, '0'),
(4, 0, 'Deleted', '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `languages`
--

INSERT INTO `languages` (`id`, `name`, `view`, `page_up`, `delete`) VALUES
(2, 'en', '1', 4, '0'),
(3, 'ro', '0', 3, '0'),
(4, 'ru', '1', 1, '0'),
(5, 'de', '0', 2, '0'),
(6, 'fr', '0', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `let_alone` enum('0','1') NOT NULL DEFAULT '0',
  `page_up` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `url`, `view`, `let_alone`, `page_up`, `delete`) VALUES
(4, 0, '/', '1', '1', 0, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `menu_lang`
--

CREATE TABLE IF NOT EXISTS `menu_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `seo_title` text NOT NULL,
  `seo_description` text NOT NULL,
  `seo_keywords` text NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `menu_lang`
--

INSERT INTO `menu_lang` (`id`, `post_id`, `name`, `text`, `seo_title`, `seo_description`, `seo_keywords`, `id_lang`, `delete`) VALUES
(1, 4, 'Home fr edit', '', '', '', '', 6, '0'),
(2, 4, 'Home de', '', '', '', '', 5, '0'),
(3, 4, 'Home', '&lt;h1&gt;КАКУЮ ПЕНСИЮ ВЫ СЧИТАЕТЕ ДОСТОЙНОЙ И СКОЛЬКО ГОТОВЫ ЕЖЕМЕСЯЧНО ОТДАВАТЬ С ЗАРПЛАТЫ В ПФ ДЛЯ ЕЕ ОБЕСПЕЧЕНИЯ?&lt;/h1&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.&lt;br /&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.&lt;br /&gt;\r\n&lt;br /&gt;\r\nЕсли родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта. Если родительская категория не указана, то это категория верхнего уровня. Порядок отображения категорий также назначается администратором сайта.', '', '', '', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `notification_status`
--

CREATE TABLE IF NOT EXISTS `notification_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `notification_status`
--

INSERT INTO `notification_status` (`id`, `name`, `view`, `page_up`, `delete`) VALUES
(4, 'Completed', '1', 1, '0'),
(5, 'Not complete', '1', 3, '0'),
(6, 'Completed in part', '1', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `notification_system`
--

CREATE TABLE IF NOT EXISTS `notification_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `date` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=135 ;

--
-- Дамп данных таблицы `notification_system`
--

INSERT INTO `notification_system` (`id`, `parent_id`, `date`, `status`, `delete`) VALUES
(21, 17, 1480708800, 6, '1'),
(22, 17, 1480190400, 5, '1'),
(23, 17, 1478548800, 4, '1'),
(24, 17, 1478548800, 4, '1'),
(26, 17, 1478548800, 4, '1'),
(29, 17, 1478548800, 4, '1'),
(32, 17, 1478548800, 4, '1'),
(87, 18, 1479067200, 6, '0'),
(94, 17, 1478034000, 5, '0'),
(95, 17, 1477947600, 6, '0'),
(96, 17, 1477861200, 4, '0'),
(97, 27, 1478116800, 4, '0'),
(98, 27, 1478203200, 6, '0'),
(101, 28, 1478203200, 6, '0'),
(102, 28, 1478116800, 5, '0'),
(105, 29, 1478203200, 6, '0'),
(106, 29, 1478116800, 5, '0'),
(107, 30, 1478203200, 6, '0'),
(108, 30, 1478116800, 5, '0'),
(109, 31, 1478203200, 6, '0'),
(110, 31, 1478116800, 5, '0'),
(112, 32, 0, 4, '0'),
(113, 33, 0, 4, '0'),
(114, 34, 0, 4, '0'),
(115, 35, 0, 4, '0'),
(116, 38, 0, 4, '0'),
(117, 39, 0, 4, '0'),
(118, 40, 0, 4, '0'),
(119, 41, 0, 4, '0'),
(120, 42, 0, 4, '0'),
(121, 12, 1480968000, 4, '0'),
(122, 43, 1480968000, 4, '0'),
(123, 44, 1480968000, 4, '0'),
(124, 45, 1480968000, 4, '0'),
(125, 46, 1480968000, 4, '0'),
(126, 47, 1482789600, 4, '0'),
(134, 48, 1482447600, 4, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `notification_system_lang`
--

CREATE TABLE IF NOT EXISTS `notification_system_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=233 ;

--
-- Дамп данных таблицы `notification_system_lang`
--

INSERT INTO `notification_system_lang` (`id`, `post_id`, `text`, `id_lang`, `delete`) VALUES
(42, 21, '', 4, '1'),
(43, 21, '', 3, '1'),
(44, 22, '', 4, '1'),
(45, 22, '', 3, '1'),
(46, 23, '', 4, '1'),
(47, 23, '', 3, '1'),
(48, 24, '', 4, '1'),
(49, 24, '', 3, '1'),
(174, 87, '', 5, '0'),
(187, 94, 'ru txt 1', 4, '0'),
(188, 94, '', 5, '0'),
(189, 95, 'ru txt 2', 4, '0'),
(190, 95, 'de txt 2', 5, '0'),
(191, 96, 'ru txt 3', 4, '0'),
(192, 96, '', 5, '0'),
(193, 97, '​Text ro not 1', 3, '0'),
(194, 97, 'Text ru not', 4, '0'),
(195, 98, '​Text ro not 2', 3, '0'),
(196, 98, '​​Text ru not 2', 4, '0'),
(197, 101, 'text 1 ru', 4, '0'),
(198, 101, 'text 1 ro', 3, '0'),
(199, 102, 'text 2 ru', 4, '0'),
(200, 102, '​text 2 ro', 3, '0'),
(201, 105, 'ttt ru 1', 4, '0'),
(202, 105, '​​ttt ro 1', 3, '0'),
(203, 106, 'ttt ru 2', 4, '0'),
(204, 106, '​ttt ro 2', 3, '0'),
(205, 109, 'ttt ru 1', 4, '0'),
(206, 109, '​​ttt ro 1', 3, '0'),
(207, 110, 'ttt ru 2', 4, '0'),
(208, 110, '​ttt ro 2', 3, '0'),
(210, 112, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(211, 113, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(212, 114, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(213, 115, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(214, 116, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(215, 117, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(216, 118, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(217, 119, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(218, 120, 'фыв\r\n<div style="margin-left: 40px;">&nbsp;</div>\r\n', 3, '0'),
(219, 121, 'фыв\r\n<div style="margin-left:40px">&nbsp;</div>\r\n', 3, '0'),
(220, 122, 'фыв\r\n<div style="margin-left:40px">&nbsp;</div>\r\n', 3, '0'),
(221, 123, 'фыв\r\n<div style="margin-left:40px">&nbsp;</div>\r\n', 3, '0'),
(222, 124, 'фыв\r\n<div style="margin-left:40px">&nbsp;</div>\r\n', 3, '0'),
(223, 125, 'фыв\r\n<div style="margin-left:40px">&nbsp;</div>\r\n', 3, '0'),
(224, 126, 'asdasdasd', 2, '0'),
(232, 134, 'Lorem notification! edit', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `notification_system_log`
--

CREATE TABLE IF NOT EXISTS `notification_system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(25) NOT NULL,
  `id_interview` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Дамп данных таблицы `notification_system_log`
--

INSERT INTO `notification_system_log` (`id`, `email`, `id_interview`, `type`, `date`) VALUES
(1, 'DQ,,', 48, 4, 1481661843),
(2, 'DA,,', 48, 4, 1481661843),
(3, 'Cg,,', 48, 4, 1481661843),
(4, 'Cw,,', 48, 4, 1481661843),
(5, 'CA,,', 48, 4, 1481661843),
(6, 'DQ,,', 48, 4, 1481662571),
(7, 'DA,,', 48, 4, 1481662571),
(8, 'Cg,,', 48, 4, 1481662571),
(9, 'Cw,,', 48, 4, 1481662571),
(10, 'CA,,', 48, 4, 1481662571),
(11, 'DQ,,', 48, 4, 1481664908),
(12, 'DA,,', 48, 4, 1481664908),
(13, 'Cg,,', 48, 4, 1481664908),
(14, 'Cw,,', 48, 4, 1481664908),
(15, 'CA,,', 48, 4, 1481664908),
(16, 'DQ,,', 48, 4, 1481665029),
(17, 'DA,,', 48, 4, 1481665029),
(18, 'Cg,,', 48, 4, 1481665029),
(19, 'Cw,,', 48, 4, 1481665029),
(20, 'CA,,', 48, 4, 1481665029),
(21, 'DQ,,', 48, 4, 1481665045),
(22, 'DA,,', 48, 4, 1481665045),
(23, 'Cg,,', 48, 4, 1481665045),
(24, 'Cw,,', 48, 4, 1481665045),
(25, 'CA,,', 48, 4, 1481665045),
(26, 'DQ,,', 48, 4, 1481665053),
(27, 'DA,,', 48, 4, 1481665053),
(28, 'Cg,,', 48, 4, 1481665053),
(29, 'Cw,,', 48, 4, 1481665054),
(30, 'CA,,', 48, 4, 1481665054),
(31, 'DQ,,', 48, 4, 1482503516),
(32, 'DA,,', 48, 4, 1482503516),
(33, 'Cg,,', 48, 4, 1482503516),
(34, 'Cw,,', 48, 4, 1482503516),
(35, 'CA,,', 48, 4, 1482503516),
(36, 'DQ,,', 48, 4, 1482503618),
(37, 'DA,,', 48, 4, 1482503618),
(38, 'Cg,,', 48, 4, 1482503618),
(39, 'Cw,,', 48, 4, 1482503618),
(40, 'CA,,', 48, 4, 1482503618),
(41, 'DQ,,', 48, 4, 1482503686),
(42, 'DA,,', 48, 4, 1482503686),
(43, 'Cg,,', 48, 4, 1482503687),
(44, 'Cw,,', 48, 4, 1482503687),
(45, 'CA,,', 48, 4, 1482503687),
(46, 'DQ,,', 48, 4, 1482504937),
(47, 'DA,,', 48, 4, 1482504937),
(48, 'Cg,,', 48, 4, 1482504937),
(49, 'Cw,,', 48, 4, 1482504937),
(50, 'CA,,', 48, 4, 1482504937),
(51, 'DQ,,', 48, 4, 1482504962),
(52, 'DA,,', 48, 4, 1482504962),
(53, 'Cg,,', 48, 4, 1482504962),
(54, 'Cw,,', 48, 4, 1482504962),
(55, 'CA,,', 48, 4, 1482504963);

-- --------------------------------------------------------

--
-- Структура таблицы `periodic_answer_question`
--

CREATE TABLE IF NOT EXISTS `periodic_answer_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_interview` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

--
-- Дамп данных таблицы `periodic_answer_question`
--

INSERT INTO `periodic_answer_question` (`id`, `id_interview`, `id_user`, `id_chapter`, `answer`) VALUES
(81, 48, 57, 47, '{"32":"85","33":"89"}'),
(82, 48, 57, 45, '{"29":"81","28":{"77":"on","78":"on","79":"on"},"27":"csasda"}');

-- --------------------------------------------------------

--
-- Структура таблицы `privilege`
--

CREATE TABLE IF NOT EXISTS `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `define` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `privilege`
--

INSERT INTO `privilege` (`id`, `define`, `name`) VALUES
(1, 'ADD_ADMIN', 'Add Administrator'),
(2, 'EDIT_ADMIN', 'Edit Administrator'),
(3, 'TRASH_ADMIN', 'Remove Administrator'),
(4, 'VIEW_ANSWER_RESULT', 'View the results of the responses'),
(5, 'WORKING_WITH_SURVEY', 'Working with survey'),
(6, 'DEACTIVATE_ADMIN', 'Deactivate Administrator'),
(7, 'VIEW_STATISTICS', 'See Statistics');

-- --------------------------------------------------------

--
-- Структура таблицы `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `id_lang` int(11) NOT NULL,
  `view` enum('0','1') NOT NULL DEFAULT '1',
  `page_up` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Дамп данных таблицы `projects`
--

INSERT INTO `projects` (`id`, `parent_id`, `id_lang`, `view`, `page_up`, `delete`) VALUES
(30, 35, 2, '1', 1, '0'),
(31, 30, 4, '1', 1, '0'),
(32, 0, 5, '1', 5, '0'),
(33, 32, 6, '1', 1, '0'),
(34, 0, 2, '1', 0, '1'),
(35, 0, 3, '1', 4, '0'),
(36, 0, 3, '1', 3, '0'),
(37, 0, 5, '1', 2, '0'),
(38, 31, 6, '1', 1, '0'),
(39, 0, 3, '1', 1, '0'),
(40, 0, 4, '1', 0, '1'),
(41, 0, 2, '1', 0, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `projects_lang`
--

CREATE TABLE IF NOT EXISTS `projects_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_lang` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=255 ;

--
-- Дамп данных таблицы `projects_lang`
--

INSERT INTO `projects_lang` (`id`, `post_id`, `name`, `id_lang`, `delete`) VALUES
(157, 31, '1', 6, '1'),
(158, 31, '1', 4, '1'),
(159, 31, '1', 5, '1'),
(160, 31, '1', 3, '1'),
(161, 31, '1', 2, '1'),
(167, 32, '1', 6, '1'),
(168, 32, '1', 4, '1'),
(169, 32, '1', 5, '1'),
(170, 32, '1', 3, '1'),
(171, 32, '1', 2, '1'),
(182, 33, '1', 6, '1'),
(183, 33, '1', 4, '1'),
(184, 33, '1', 5, '1'),
(185, 33, '1', 3, '1'),
(186, 33, '1', 2, '1'),
(192, 31, 'project 3 fr', 6, '0'),
(193, 31, 'project 3 ru', 4, '0'),
(194, 31, 'project 3 de', 5, '0'),
(195, 31, 'project 3 ro', 3, '0'),
(196, 31, 'project 3 en', 2, '0'),
(197, 32, 'project 4 fr', 6, '0'),
(198, 32, 'project 4 ru', 4, '0'),
(199, 32, 'project 4 de', 5, '0'),
(200, 32, 'project 4 ro', 3, '0'),
(201, 32, 'project 4 en', 2, '0'),
(202, 33, 'project 4 fr', 6, '0'),
(203, 33, 'project 4 ru', 4, '0'),
(204, 33, 'project 4 de', 5, '0'),
(205, 33, 'project 4 ro', 3, '0'),
(206, 33, 'project 4 en', 2, '0'),
(207, 34, '1', 6, '0'),
(208, 34, '1', 4, '0'),
(209, 34, '1', 5, '0'),
(210, 34, '1', 3, '0'),
(211, 34, '1', 2, '0'),
(217, 30, 'project 2 fr', 6, '0'),
(218, 30, 'project 2 ru', 4, '0'),
(219, 30, 'project 2 de', 5, '0'),
(220, 30, 'project 2 ro', 3, '0'),
(221, 30, 'project 2 en', 2, '0'),
(227, 35, 'project 1 fr', 6, '0'),
(228, 35, 'project 1 ru', 4, '0'),
(229, 35, 'project 1 de', 5, '0'),
(230, 35, 'project 1 ro', 3, '0'),
(231, 35, 'project 1 en', 2, '0'),
(232, 36, 'test pr', 6, '0'),
(233, 36, '', 4, '0'),
(234, 36, '', 5, '0'),
(235, 36, '', 3, '0'),
(236, 36, 'test pr en', 2, '0'),
(237, 37, '', 6, '0'),
(238, 37, '', 4, '0'),
(239, 37, '', 5, '0'),
(240, 37, '', 3, '0'),
(241, 37, 'test pr en e', 2, '0'),
(242, 38, '', 6, '0'),
(243, 38, '', 4, '0'),
(244, 38, '', 5, '0'),
(245, 38, '', 3, '0'),
(246, 38, 'Project new en', 2, '0'),
(247, 39, 'Интернет-магазин продуктов', 4, '0'),
(248, 39, 'Supermarket online', 2, '0'),
(249, 40, 'test test', 6, '0'),
(250, 40, '', 5, '0'),
(251, 40, '', 2, '0'),
(252, 41, 'test test', 6, '0'),
(253, 41, '', 5, '0'),
(254, 41, '', 2, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `page_up` int(11) NOT NULL DEFAULT '0',
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`id`, `name`, `page_up`, `delete`) VALUES
(1, 'Super admin', 1, '0'),
(2, 'Admin', 2, '0'),
(3, 'Assistant', 3, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('input','checkbox','select') NOT NULL DEFAULT 'input',
  `var` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `page_up` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `type`, `var`, `name`, `value`, `page_up`) VALUES
(1, 'input', 'interval_update_password', 'The time interval for updating the password (day''s)', '10', 0),
(2, 'select', 'data_lang', 'Language for data', 'en', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `survey_access`
--

CREATE TABLE IF NOT EXISTS `survey_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_interview` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `survey_access`
--

INSERT INTO `survey_access` (`id`, `id_user`, `id_interview`, `start_date`, `hash`) VALUES
(1, 57, 48, 1483117814, '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_type` enum('fb','ok','vk','g','default') NOT NULL DEFAULT 'default',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `subscribe` enum('0','1') NOT NULL DEFAULT '0',
  `oauth_id` int(11) NOT NULL,
  `forgot_hash` varchar(255) NOT NULL,
  `register_date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login_type`, `email`, `password`, `username`, `phone`, `location`, `address`, `comment`, `subscribe`, `oauth_id`, `forgot_hash`, `register_date`) VALUES
(8, 'vk', '', '', 'Даник Флянку', '', '', '', '', '0', 214959138, '', 1478531555);

-- --------------------------------------------------------

--
-- Структура таблицы `user_privileges`
--

CREATE TABLE IF NOT EXISTS `user_privileges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_privilege` int(11) NOT NULL,
  `value` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Дамп данных таблицы `user_privileges`
--

INSERT INTO `user_privileges` (`id`, `id_role`, `id_user`, `id_privilege`, `value`) VALUES
(3, 1, 0, 1, '0'),
(4, 1, 0, 2, '0'),
(5, 2, 0, 5, '0'),
(14, 1, 17, 2, '0'),
(15, 1, 17, 6, '0'),
(16, 1, 19, 1, '0'),
(17, 1, 19, 2, '0'),
(18, 1, 19, 3, '0'),
(19, 1, 19, 4, '0'),
(20, 1, 19, 5, '0'),
(21, 1, 19, 6, '0'),
(22, 1, 19, 7, '0'),
(54, 3, 21, 1, '0'),
(55, 3, 21, 2, '0'),
(56, 3, 21, 5, '0'),
(57, 3, 21, 7, '0'),
(61, 2, 20, 1, '0'),
(62, 2, 20, 2, '0'),
(63, 2, 20, 5, '0'),
(64, 2, 20, 7, '0'),
(65, 3, 22, 2, '0'),
(66, 3, 22, 6, '0'),
(67, 3, 23, 1, '0'),
(68, 3, 23, 2, '0'),
(69, 3, 23, 7, '0');

-- --------------------------------------------------------

--
-- Структура таблицы `user_projects`
--

CREATE TABLE IF NOT EXISTS `user_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_project` int(11) NOT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=71 ;

--
-- Дамп данных таблицы `user_projects`
--

INSERT INTO `user_projects` (`id`, `id_user`, `id_project`, `delete`) VALUES
(17, 17, 35, '1'),
(18, 17, 31, '1'),
(19, 17, 32, '1'),
(20, 17, 33, '1'),
(50, 21, 37, '1'),
(51, 21, 36, '1'),
(52, 21, 35, '1'),
(53, 21, 30, '1'),
(54, 21, 31, '1'),
(55, 21, 38, '1'),
(56, 21, 39, '1'),
(65, 20, 35, '0'),
(66, 20, 30, '0'),
(67, 20, 31, '0'),
(68, 20, 38, '0'),
(69, 19, 40, '0'),
(70, 19, 41, '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
