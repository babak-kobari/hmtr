-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 01, 2012 at 12:56 AM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zfcore`
--

-- --------------------------------------------------------

--
-- Table structure for table `hm_menu`
--

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

--
-- Dumping data for table `hm_menu`
--

INSERT INTO `hm_menu` (`id`, `label`, `title`, `type`, `params`, `parentId`, `position`, `route`, `uri`, `class`, `target`, `active`, `visible`, `routeType`, `module`, `controller`, `action`) VALUES
(1, 'Home', 'home', 'uri', '{"uri":"/","visible":"1","active":"0"}', 0, 0, NULL, '/', NULL, '', 0, 1, NULL, NULL, NULL, NULL),
(2, 'Registration', 'register', 'mvc', '{"type":"bot"}', 1, 9, 'default', NULL, 'register', '_parent', 0, 1, 'module', 'users', 'register', 'index'),
(3, 'Forget Password', 'Forget Password', 'mvc', '', 2, 1, 'forgetPassword', NULL, NULL, '', 0, 1, 'static', 'users', 'register', 'forget-password'),
(4, 'Login', 'login', 'mvc', '', 1, 2, 'login', NULL, 'login', '', 0, 1, 'static', 'users', 'login', 'index'),
(5, 'Forum', 'Forum', 'mvc', '', 1, 3, 'default', NULL, 'Forum', '', 0, 1, 'module', 'forum', 'index', 'index'),
(6, 'Terms of use', 'Terms of use', 'mvc', '{"alias":"terms"}', 1, 10, 'pages', NULL, '', '', 0, 1, 'regex', 'pages', 'index', 'index'),
(7, 'Privacy policy', 'Privacy policy', 'mvc', '{"alias":"privacy"}', 6, 1, 'pages', NULL, '', '', 0, 1, 'regex', 'pages', 'index', 'index'),
(8, 'Terms and conditions', 'Terms and conditions', 'mvc', '{"alias":"conditions"}', 6, 2, 'pages', NULL, '', '', 0, 1, 'regex', 'pages', 'index', 'index'),
(30, 'Sitemap', 'sitemap', 'mvc', '', 1, 4, 'sitemap', NULL, 'sitemap', '', 0, 1, 'static', 'pages', 'index', 'sitemap'),
(35, 'logout', 'logout', 'mvc', '', 1, 7, 'logout', NULL, 'logout', '', 0, 1, 'static', 'users', 'login', 'logout'),
(34, 'Admin panel', 'Admin panel', 'mvc', '', 1, 1, 'default', NULL, 'adminka', '', 0, 1, 'module', 'admin', 'index', 'index'),
(27, 'About', 'about', 'mvc', '{"alias":"about"}', 1, 5, 'pages', NULL, 'about', '_self', 0, 1, 'regex', 'pages', 'index', 'index'),
(41, 'test', 'test', 'mvc', '{"alias":"test"}', 27, 1, 'pages', NULL, 'test', '', 0, 1, 'regex', 'pages', 'index', 'index'),
(39, 'Faq', 'Faq', 'mvc', '{"alias":"faq"}', 1, 8, 'pages', NULL, 'Faq', '', 0, 1, 'regex', 'pages', 'index', 'index');
