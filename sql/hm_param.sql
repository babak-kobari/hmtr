-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2012 at 03:47 PM
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
-- Table structure for table `hm_param`
--

CREATE TABLE IF NOT EXISTS `hm_param` (
  `param_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `param_type` varchar(10) DEFAULT NULL,
  `param_category_id` varchar(20) DEFAULT NULL,
  `param_category_desc` varchar(50) DEFAULT NULL,
  `param_action` varchar(1) DEFAULT NULL,
  `param_published` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`param_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=356 ;
