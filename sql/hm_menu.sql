-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2012 at 12:42 AM
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
-- Table structure for table `hm_menu`
--

DROP TABLE IF EXISTS `hm_menu`;
CREATE TABLE IF NOT EXISTS `hm_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` enum('uri','mvc') DEFAULT 'uri',
  `params` text,
  `parentId` int(10) unsigned DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `route` varchar(255) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `target` enum('','_blank','_parent','_self','_top') DEFAULT '',
  `active` tinyint(1) DEFAULT '0',
  `visible` tinyint(1) DEFAULT '1',
  `routeType` varchar(40) DEFAULT NULL,
  `module` varchar(40) DEFAULT NULL,
  `controller` varchar(40) DEFAULT NULL,
  `action` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parentId` (`parentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;
