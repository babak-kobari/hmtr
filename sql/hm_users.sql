-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2012 at 03:50 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `hm_users`
--

CREATE TABLE IF NOT EXISTS `hm_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `avatar` varchar(512) DEFAULT NULL,
  `role` enum('guest','user','admin') NOT NULL DEFAULT 'guest',
  `status` enum('active','blocked','registered','removed') NOT NULL DEFAULT 'registered',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '2000-01-01 00:00:00',
  `logined` timestamp NOT NULL DEFAULT '2000-01-01 00:00:00',
  `ip` int(11) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT '1',
  `hashCode` varchar(32) DEFAULT NULL,
  `inform` enum('true','false') NOT NULL DEFAULT 'false',
  `facebookId` varchar(250) DEFAULT NULL COMMENT 'facebook ID',
  `twitterId` varchar(250) DEFAULT NULL COMMENT 'twitter ID',
  `googleId` varchar(250) DEFAULT NULL COMMENT 'google ID',
  `birth_date` date DEFAULT NULL,
  `nationality` int(10) DEFAULT NULL,
  `currentlocation` int(10) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `about_me` varchar(2000) DEFAULT NULL,
  `travel_style` int(10) DEFAULT NULL,
  `travel_type` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_login` (`login`),
  UNIQUE KEY `unique_email` (`email`),
  UNIQUE KEY `activate` (`hashCode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10068 ;

--
-- Dumping data for table `hm_users`
--

INSERT INTO `hm_users` (`id`, `login`, `email`, `password`, `salt`, `firstname`, `lastname`, `avatar`, `role`, `status`, `created`, `updated`, `logined`, `ip`, `count`, `hashCode`, `inform`, `facebookId`, `twitterId`, `googleId`, `birth_date`, `nationality`, `currentlocation`, `gender`, `about_me`, `travel_style`, `travel_type`) VALUES
(10067, 'babak', 'bb@b2b2.com', '643ea1f0edbc388c25eb35722a610dd6', 'eaf1d8505e846732a3e7ba4e6e4efd01', 'babak', 'kobari', NULL, 'user', 'active', '2012-10-06 19:19:08', '2012-12-11 18:03:43', '2012-12-11 18:03:43', 2130706433, 59, '588d47615180f47d83e429b489464301', 'false', NULL, NULL, NULL, '2012-12-12', 23, 23, 1, 'sdafsdf', 260, 23);
