-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2013 at 01:35 AM
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
-- Table structure for table `hm_exp_head`
--

DROP TABLE IF EXISTS `hm_exp_head`;
CREATE TABLE IF NOT EXISTS `hm_exp_head` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_user_id` int(11) NOT NULL,
  `exp_title` varchar(200) NOT NULL,
  `exp_country` int(11) NOT NULL,
  `exp_city` varchar(20) NOT NULL,
  `exp_mount` varchar(15) NOT NULL,
  `exp_days` int(2) NOT NULL,
  `exp_adults` int(2) NOT NULL,
  `exp_childs` int(2) NOT NULL,
  `exp_overall_rate` int(1) NOT NULL DEFAULT '0',
  `exp_travel_type` int(11) NOT NULL,
  `exp_travel_objective` int(11) NOT NULL,
  `exp_total_cost` int(11) DEFAULT '0',
  `exp_user_rating` decimal(10,0) DEFAULT '0',
  `exp_total_rated` int(11) DEFAULT '0',
  `exp_total_helpful` int(11) DEFAULT '0',
  `exp_status` varchar(11) DEFAULT 'WIP',
  PRIMARY KEY (`exp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `hm_exp_head`
--

INSERT INTO `hm_exp_head` (`exp_id`, `exp_user_id`, `exp_title`, `exp_country`, `exp_city`, `exp_mount`, `exp_days`, `exp_adults`, `exp_childs`, `exp_overall_rate`, `exp_travel_type`, `exp_travel_objective`, `exp_total_cost`, `exp_user_rating`, `exp_total_rated`, `exp_total_helpful`, `exp_status`) VALUES
(1, 1, 'Exciting relaxation in exotic environment', 8, 'Dubai', 'Jan', 6, 2, 0, 0, 1, 6, 2500, '0', 0, 0, 'WIP');
