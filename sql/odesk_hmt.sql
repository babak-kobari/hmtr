-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2013 at 09:05 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `odesk_hmt`
--

-- --------------------------------------------------------

--
-- Table structure for table `hm_ user_comments`
--

CREATE TABLE IF NOT EXISTS `hm_ user_comments` (
  `comm_id` int(11) NOT NULL AUTO_INCREMENT,
  `comm_message` varchar(200) NOT NULL,
  `wall_id` int(11) NOT NULL COMMENT 'reference to hm_user_wall table(wall_id)',
  `user_id` int(11) NOT NULL COMMENT 'Reference to hm_user table (id)',
  `comm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comm_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1->Active,0->Deactive',
  PRIMARY KEY (`comm_id`),
  KEY `fm_comm_wall_idx` (`wall_id`),
  KEY `fk_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hm_user_wall`
--

CREATE TABLE IF NOT EXISTS `hm_user_wall` (
  `wall_id` int(11) NOT NULL AUTO_INCREMENT,
  `wall_message` varchar(200) DEFAULT NULL,
  `exp_id` int(11) NOT NULL,
  `wall_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `wall_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1->Active,0->Deactive',
  PRIMARY KEY (`wall_id`),
  UNIQUE KEY `exp_id` (`wall_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hm_ user_comments`
--
ALTER TABLE `hm_ user_comments`
  ADD CONSTRAINT `fk_comm_user` FOREIGN KEY (`user_id`) REFERENCES `hm_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comm_wall` FOREIGN KEY (`wall_id`) REFERENCES `hm_user_wall` (`wall_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
