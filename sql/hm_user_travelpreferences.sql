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
-- Table structure for table `hm_user_travelpreferences`
--

DROP TABLE IF EXISTS `hm_user_travelpreferences`;
CREATE TABLE IF NOT EXISTS `hm_user_travelpreferences` (
  `trvint_id` int(10) NOT NULL AUTO_INCREMENT,
  `trvint_user_id` int(10) NOT NULL,
  `trvint_cat` varchar(20) NOT NULL,
  `trvint_param_id` int(10) NOT NULL,
  `trvint_rate` int(2) NOT NULL,
  PRIMARY KEY (`trvint_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;
