-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2012 at 12:43 AM
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
-- Table structure for table `hm_poi`
--

DROP TABLE IF EXISTS `hm_poi`;
CREATE TABLE IF NOT EXISTS `hm_poi` (
  `poi_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poi_name` varchar(200) DEFAULT NULL,
  `poi_group_name` varchar(200) DEFAULT NULL,
  `poi_ranking` int(5) DEFAULT NULL,
  `poi_trip_advisor_ranking` int(5) DEFAULT NULL,
  `poi_type` varchar(5) NOT NULL,
  `poi_stay_type` int(11) DEFAULT NULL,
  `poi_stay_calssification` varchar(10) DEFAULT NULL,
  `poi_country` varchar(200) DEFAULT NULL,
  `poi_city` varchar(200) DEFAULT NULL,
  `poi_area` varchar(200) DEFAULT NULL,
  `poi_lat` varchar(40) DEFAULT NULL,
  `poi_lon` varchar(40) DEFAULT NULL,
  `poi_location_type` int(5) DEFAULT NULL,
  `poi_web_site` varchar(100) DEFAULT NULL,
  `poi_contact detail` varchar(200) DEFAULT NULL,
  `poi_restaurant_type` int(11) DEFAULT NULL,
  `poi_dining option` int(11) DEFAULT NULL,
  `poi_halal_yn` int(11) DEFAULT NULL,
  `poi_things_type` int(11) DEFAULT NULL,
  `poi_activity_type` int(11) DEFAULT NULL,
  `poi_working_Time` int(11) DEFAULT NULL,
  `poi_average_cost` int(11) DEFAULT NULL,
  PRIMARY KEY (`poi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;
