-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2012 at 03:49 PM
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
-- Table structure for table `hm_related_poi`
--

CREATE TABLE IF NOT EXISTS `hm_related_poi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_poi_id` int(10) DEFAULT NULL,
  `related_poi_id` int(10) DEFAULT NULL,
  `poi_type` varchar(5) NOT NULL,
  `poi_distance` int(10) DEFAULT NULL,
  `poi_distance_uom` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;
