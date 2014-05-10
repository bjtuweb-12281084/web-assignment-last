-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 05 月 10 日 00:38
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `webhomework`
--
CREATE DATABASE IF NOT EXISTS `webhomework` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `webhomework`;

-- --------------------------------------------------------

--
-- 表的结构 `book`
--

CREATE TABLE IF NOT EXISTS `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(12) NOT NULL,
  `time` varchar(10) NOT NULL,
  `info` text,
  `reply` text,
  `audit` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `book`
--

INSERT INTO `book` (`id`, `ip`, `time`, `info`, `reply`, `audit`) VALUES
(1, '127.0.0.1', '1399679521', 'first', 'ok', 1),
(2, '127.0.0.1', '1399679575', 'hiahiahia', '', 1),
(3, '127.0.0.1', '1399679584', 'dododo', NULL, 0),
(4, '127.0.0.1', '1399679589', 'asasas', 'è¿™äº›', 1),
(5, '127.0.0.1', '1399679596', 'qwqwqw\r\n', 'ä¸‹æ¬¡', 1),
(6, '127.0.0.1', '1399679612', 'webtest', NULL, 0),
(7, '127.0.0.1', '1399679628', 'lalala', '', 1),
(8, '127.0.0.1', '1399679634', 'å¾—å¾—å¾—', NULL, 0),
(9, '127.0.0.1', '1399679642', 'å¦®å¦®å¦®', '', 1),
(10, '127.0.0.1', '1399679669', 'ä¸œæ–¹äºº', 'åŒå–œåŒå–œ', 1),
(11, '127.0.0.1', '1399679686', 'æµ‹è¯•å®Œæ¯•ï¼Œäº¤ä½œä¸šå•¦~~~', 'æ­å–œæ­å–œ', 1);

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(50) NOT NULL,
  `pswd` varchar(32) NOT NULL,
  `audit` int(1) NOT NULL,
  `info` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`name`, `pswd`, `audit`, `info`) VALUES
('web-homework', '21232f297a57a5a743894a0e4a801fc3', 1, 'å¯†ç ï¼šadmin ');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
