-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2013 at 08:54 PM
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
-- Table structure for table `hm_user_trvlprfns_trv_with`
--

DROP TABLE IF EXISTS `hm_user_trvlprfns_trv_with`;
CREATE TABLE IF NOT EXISTS `hm_user_trvlprfns_trv_with` (
  `trvint_id` int(10) NOT NULL AUTO_INCREMENT,
  `trvint_user_id` int(10) NOT NULL,
  `trvint_param_id` int(10) NOT NULL,
  `trvint_rate` int(2) NOT NULL,
  PRIMARY KEY (`trvint_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;
