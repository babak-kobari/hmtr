-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 08, 2012 at 07:39 PM
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
-- Table structure for table `hm_poi_facl`
--

DROP TABLE IF EXISTS `hm_poi_facl`;
CREATE TABLE IF NOT EXISTS `hm_poi_facl` (
  `poifcl_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `poifcl_poi_id` int(10) NOT NULL,
  `poifcl_param_id` int(10) NOT NULL,
  PRIMARY KEY (`poifcl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;
