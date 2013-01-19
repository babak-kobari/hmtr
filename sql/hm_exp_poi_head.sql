-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 17, 2012 at 10:06 PM
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
-- Table structure for table `hm_exp_poi_head`
--

CREATE TABLE IF NOT EXISTS `hm_exp_poi_head` (
  `exp_poi_head_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_head_id` int(11) NOT NULL,
  `exp_poi_id` int(11) NOT NULL,
  `exp_poi_average_cost` int(11) DEFAULT '0',
  `exp_stay_room_type` varchar(100) DEFAULT NULL,
  `exp_stay_room_view` varchar(100) DEFAULT NULL,
  `exp_poi_short_description` varchar(2000) DEFAULT NULL,
  `exp_poi_overal_rating` int(11) NOT NULL DEFAULT '0',
  `exp_stay_room_rating` int(11) NOT NULL DEFAULT '0',
  `exp_eat_your_dish1` varchar(200) DEFAULT NULL,
  `exp_eat_your_dish2` varchar(200) DEFAULT NULL,
  `exp_eat_your_dish3` varchar(200) DEFAULT NULL,
  `exp_poi_average_time` int(11) DEFAULT '0',
  `exp_poi_special_conditiom``` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`exp_poi_head_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;
