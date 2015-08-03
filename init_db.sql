-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2015 at 11:55 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quotequiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_correct` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `title`, `author`, `is_correct`) VALUES
(1, 1, 'Ivan Vazov', 'Vasil Levski', 0),
(2, 1, 'Hristo Botev', 'Vasil Levski', 0),
(3, 1, 'Vasil Levski', 'Vasil Levski', 1),
(4, 2, 'Oscar Wilde', 'Sir Winston Churchil', 0),
(5, 2, 'Sir Winston Churchil', 'Sir Winston Churchil', 1),
(6, 2, 'Hector Berlioz', 'Sir Winston Churchil', 0),
(7, 3, 'Aleko Konstantinov', 'Vasil Levski', 0),
(8, 3, 'Vasil Levski', 'Vasil Levski', 1),
(9, 3, 'Georgi Rakovski', 'Vasil Levski', 0),
(10, 4, 'Oscar Wilde', 'Oscar Wilde', 1),
(11, 5, 'Aleko Konstantinov', 'Aleko Konstantinov', 1),
(12, 6, 'Paisii Hilendarski', 'Aleko Konstantinov', 0),
(14, 7, 'Steve Maraboli', 'Bruce Barton', 0),
(15, 8, 'Steve Maraboli', 'Steve Maraboli', 1),
(16, 9, 'Steve Maraboli', 'Ralph Waldo Emerson', 0),
(17, 9, 'Ralph Waldo Emerson', 'Ralph Waldo Emerson', 1),
(18, 9, 'Wayne W. Dyer', 'Ralph Waldo Emerson', 0),
(19, 10, 'Ralph Waldo Emerson', 'Steve Maraboli', 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_id` int(11) NOT NULL,
  `order` int(11) NOT NULL COMMENT 'show question order',
  `type` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `quiz_id`, `order`, `type`, `title`) VALUES
(1, 1, 1, 2, 'If I win win for all the people, if I lose I lose itself'),
(2, 1, 2, 2, 'It has been said that democracy is the worst form of government, except all those others that have been tried'),
(3, 1, 3, 2, 'Guns, guns and again guns.'),
(4, 1, 4, 1, 'A dreamer is one who can only find his way by moonlight, and his punishment is that he sees the dawn before the rest of the world'),
(5, 1, 5, 1, 'Some people, some ideal'),
(6, 1, 6, 1, 'Know the Motherland, to love it'),
(7, 1, 7, 1, 'Nothing splendid has ever been achieved except by those who dared believe that something inside them was superior to circumstance'),
(8, 1, 8, 1, 'Happiness is not the absence of problems, it''s the ability to deal with them'),
(9, 1, 9, 2, 'Without ambition one starts nothing. Without work one finishes nothing. The prize will not be sent to you. You have to win it'),
(10, 1, 10, 1, 'Forget yesterday - it has already forgotten you. Don''t sweat tomorrow - you haven''t even met. Instead, open your eyes and your heart to a truly precious gift – today');

-- --------------------------------------------------------

--
-- Table structure for table `question_type`
--

CREATE TABLE IF NOT EXISTS `question_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `question_type`
--

INSERT INTO `question_type` (`id`, `title`) VALUES
(1, 'Binary (Yes/No)'),
(2, 'Multiple choice');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`id`, `title`) VALUES
(1, 'Guess who the author of the quote is?');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`type`) REFERENCES `question_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
