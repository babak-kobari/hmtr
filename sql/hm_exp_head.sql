-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2012 at 05:13 PM
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

CREATE TABLE IF NOT EXISTS `hm_exp_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_user_id` int(11) NOT NULL,
  `exp_title` varchar(200) NOT NULL,
  `exp_country` int(11) NOT NULL,
  `exp_city` int(11) NOT NULL,
  `exp_mount` int(11) NOT NULL,
  `exp_days` int(2) NOT NULL,
  `exp_adults` int(2) NOT NULL,
  `exp_childs` int(2) NOT NULL,
  `exp_overall_rate` int(1) NOT NULL,
  `exp_travel_type` int(11) NOT NULL,
  `exp_travel_objective` int(11) NOT NULL,
  `exp_total_cost` int(11) DEFAULT '0',
  `exp_user_rating` decimal(10,0) DEFAULT '0',
  `exp_total_rated` int(11) DEFAULT '0',
  `exp_total_helpful` int(11) DEFAULT '0',
  `exp_completed` int(11) DEFAULT '0',
  `exp_published` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
