-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 14 2018 г., 09:35
-- Версия сервера: 8.0.12
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
-- База данных: `labservis`
--

-- --------------------------------------------------------

--
-- Структура таблицы `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `description` varchar(600) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `course`
--

INSERT INTO `course` (`id`, `title`, `description`, `login`, `password`) VALUES
(9, 'Методы контроля оценки качества программного обеспечения', 'Как контролировать качество системы? Как точно узнать, что программа делает именно то, что нужно, и ничего другого? Как определить, что она достаточно надежна, переносима, удобна в использовании?', 'mkokpo', '3a5196991ddcc142908617dcbb7d9fdd'),
(10, 'Управление ИТ-сервисами и контентом', 'Курс предназначен для контент-менеджеров и редакторов контента, менеджеров по электронным продажам и маркетологов, веб-дизайнеров и программистов, а также блогеров и любителей.', 'usik', '66be92618503792d8ec81f511c826997'),
(12, 'Организация баз данных', 'Microsoft Access – это функционально полная реляционная СУБД. База данных в MS Access представляет собой совокупность объектов, хранящихся в одном файле с расширением mdb.', 'obd', '937d2d47530fd6d2d5eb1825df0018e9');

-- --------------------------------------------------------

--
-- Структура таблицы `lab`
--

CREATE TABLE `lab` (
  `id` int(11) NOT NULL,
  `number` tinyint(4) NOT NULL,
  `title` varchar(60) NOT NULL,
  `task` text NOT NULL,
  `attachment` varchar(600) NOT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '0',
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lab`
--

INSERT INTO `lab` (`id`, `number`, `title`, `task`, `attachment`, `access`, `course_id`) VALUES
(19, 1, 'Анализ бизнес-идеи', 'Время выполнения: 4 часа (лабораторное занятие)\r\nЗадание:\r\nЗаполнить таблицу.', '', 1, 9),
(20, 2, 'Прототипирование интерфейсов', 'Цель работы: ознакомится на практике с инструментами прототипирования, научится пользоваться ими. Попрактиковаться в создании интерфейсов.\r\nВремя выполнения: 4 часа (лабораторное занятие)\r\nЗадание:\r\nНайти в интернете любое подходящее бесплатное решение для прототипирования интерфейсов, прорисовать в нем один из вариантов заданий.\r\n', '', 1, 9),
(21, 3, 'ООП и ПП', 'Цель работы: показать знания и умения писать простые программы, используя разные парадигмы программирования. Попрактиковаться в создании интерфейсов.Время выполнения: 8 часов', '', 0, 9),
(22, 1, 'Обзор возможностей ECM-систем', 'Цель работы: познакомиться с функциональными возможностями коробочных систем управления корпоративным контентом.', '', 1, 10),
(23, 2, 'Управление каталогом ИТ-услуг', 'Задание приведено в учебно-методическом пособии по выполнению лабораторных работ.', '', 1, 10),
(27, 3, 'Разработка Service Legal Agreement (SLA)', 'Цель работы. Получить практические навыки разработки соглашения об уровне предоставления услуги (SLA)', '', 1, 10),
(28, 4, 'Анализ возможностей Helpdesk систем', 'Цель работы: закрепление теоретических знаний и формирование практических навыков по обоснованному выбору Helpdesk систем для автоматизации работы Service Desk. В процессе выполнения работы студент должен продемонстрировать способность поиска, анализа существующих на рынке решений и обоснованного выбора help desk системы.', '', 0, 10),
(29, 1, 'Построение структуры базы данных', 'Тема: Построение структуры базы данных \r\nЦель работы: разработать структуру базы данных (БД) для выбранной предметной области, содержащую не менее пяти взаимосвязанных таблиц. ', '', 1, 12),
(30, 2, 'Создание запросов с помощью построителя запросов в среде MS ', 'Тема: Создание запросов с помощью построителя запросов в среде MS Access \r\nЦель работы: создать запросы на выборку, на выборку с параметрами, на обновление записей, на удаление записей в созданных ранее таблицах. ', '', 1, 12),
(31, 3, 'Работа с формами', 'Тема: Работа с формами \r\nЦель работы: создать ленточную, табличную и сложную формы в базе данных MS Access, используя в качестве источника записей созданные ранее таблицы и запросы.\r\nПродолжительность: 4 часа.', '', 1, 12),
(32, 4, 'Работа с отчетами', 'Тема: Работа с отчетами \r\nЦель работы: создать отчеты в базе данных MS Access, используя в качестве источника записей созданные ранее таблицы и запросы.\r\n', '', 0, 12),
(33, 5, 'Создание SQL-запросов', 'Тема: Составление и исполнение запросов на языке SQL в среде СУБД MS Access XP/2003.\r\nЦель работы: создать SQL-запросы на создание таблицы, на  выборку с параметрами, на обновление записей, на удаление записей, на добавление данных, на удаление таблицы, на создание индексов.', '', 0, 12),
(37, 5, 'Леденящие душу приключения PHP программиста', 'Невероятно странный и зловещий курс о том, как не сойти с ума, пытаясь построить сайт на ООП. Уноси ноги, пока можешь', '', 0, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `lab_exec`
--

CREATE TABLE `lab_exec` (
  `id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lab_exec`
--

INSERT INTO `lab_exec` (`id`, `lab_id`) VALUES
(18, 22),
(19, 22),
(20, 22);

-- --------------------------------------------------------

--
-- Структура таблицы `lab_history`
--

CREATE TABLE `lab_history` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `answer` text NOT NULL,
  `attachment` varchar(600) NOT NULL,
  `lab_exec_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `lab_history`
--

INSERT INTO `lab_history` (`id`, `date`, `answer`, `attachment`, `lab_exec_id`) VALUES
(1, '2018-09-08', 'test', './templates/course/attachments/kotiki-ulybayutsya-01.jpg', 20),
(2, '2018-09-08', 'test2', './templates/course/attachments/nfnjxk3Ambz6Q2AqrlXN.jpg', 20),
(3, '2018-09-08', 'helloww', './templates/course/attachments/wsi-imageoptim-папка-2_00003-13.jpg', 20);

-- --------------------------------------------------------

--
-- Структура таблицы `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `learn_group` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student`
--

INSERT INTO `student` (`id`, `name`, `learn_group`) VALUES
(1, 'Семенова', '1'),
(2, 'Сатирин', '1'),
(3, 'Кузьменко', '1'),
(4, 'Трой', '1'),
(5, 'Мышкин', '1'),
(6, 'Шевцова', '2'),
(7, 'Яя', '2'),
(8, 'Тарасов', '3'),
(9, 'Индусов', '3'),
(10, 'Иванов', '3'),
(11, 'Самойленко', '311-2');

-- --------------------------------------------------------

--
-- Структура таблицы `student_course`
--

CREATE TABLE `student_course` (
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `student_course`
--

INSERT INTO `student_course` (`student_id`, `course_id`) VALUES
(1, 9),
(1, 10),
(2, 9),
(3, 9),
(4, 9),
(5, 9),
(6, 10),
(7, 10),
(5, 12),
(6, 12),
(7, 12),
(8, 12),
(9, 12),
(9, 10),
(10, 9),
(10, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `student_lab_exec`
--

CREATE TABLE `student_lab_exec` (
  `student_id` int(11) NOT NULL,
  `lab_exec_id` int(11) NOT NULL,
  `mark` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `login` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `email`, `login`, `password`) VALUES
(14, 'Троцкий Николай Анатольевич', 'tnc@gmail.com', 'tnc', 'c775cf954921a129a65eb929476de911'),
(18, 'Петров Николай Васильевич', 'pnv@yandex.ru', 'pnv', '4ea16acee0908d1f3554a179c3758edb'),
(19, 'Семенова Анна Владимировна', 'sav@yandex.ru', 'sav', 'cb20cb3deebe08865c976143b319efc5'),
(20, 'Савченко Юлия Васильевна', 'suv@mail.ru', 'suv', 'c0276be2e060fea8d3c26d0159c6e920');

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_course`
--

CREATE TABLE `teacher_course` (
  `teacher_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher_course`
--

INSERT INTO `teacher_course` (`teacher_id`, `course_id`) VALUES
(14, 9),
(18, 9),
(14, 10),
(19, 10),
(20, 12),
(14, 12);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Индексы таблицы `lab`
--
ALTER TABLE `lab`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Индексы таблицы `lab_history`
--
ALTER TABLE `lab_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_exec_id` (`lab_exec_id`);

--
-- Индексы таблицы `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);

--
-- Индексы таблицы `student_course`
--
ALTER TABLE `student_course`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Индексы таблицы `student_lab_exec`
--
ALTER TABLE `student_lab_exec`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `lab_exec_id` (`lab_exec_id`);

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT для таблицы `lab`
--
ALTER TABLE `lab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `lab_history`
--
ALTER TABLE `lab_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `lab`
--
ALTER TABLE `lab`
  ADD CONSTRAINT `lab_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lab_exec`
--
ALTER TABLE `lab_exec`
  ADD CONSTRAINT `lab_exec_ibfk_1` FOREIGN KEY (`lab_id`) REFERENCES `lab` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `lab_history`
--
ALTER TABLE `lab_history`
  ADD CONSTRAINT `lab_history_ibfk_1` FOREIGN KEY (`lab_exec_id`) REFERENCES `lab_exec` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_course`
--
ALTER TABLE `student_course`
  ADD CONSTRAINT `student_course_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_course_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_lab_exec`
--
ALTER TABLE `student_lab_exec`
  ADD CONSTRAINT `student_lab_exec_ibfk_1` FOREIGN KEY (`lab_exec_id`) REFERENCES `lab_exec` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `student_lab_exec_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teacher_course`
--
ALTER TABLE `teacher_course`
  ADD CONSTRAINT `teacher_course_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
