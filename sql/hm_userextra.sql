-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2012 at 12:44 AM
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
-- Table structure for table `hm_userextra`
--

DROP TABLE IF EXISTS `hm_userextra`;
CREATE TABLE IF NOT EXISTS `hm_userextra` (
  `wp_user_id` bigint(20) NOT NULL,
  `role` varchar(100) NOT NULL DEFAULT 'customer',
  `birth_date` date DEFAULT NULL,
  `nationality` int(10) DEFAULT NULL,
  `currentlocation` int(10) DEFAULT NULL,
  `gender` int(1) DEFAULT NULL,
  `about_me` varchar(2000) DEFAULT NULL,
  `travel_style` int(10) DEFAULT NULL,
  `travel_type` int(10) DEFAULT NULL,
  PRIMARY KEY (`wp_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
