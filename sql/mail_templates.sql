-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 31, 2012 at 12:44 AM
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
-- Table structure for table `mail_templates`
--

DROP TABLE IF EXISTS `mail_templates`;
CREATE TABLE IF NOT EXISTS `mail_templates` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `subject` text,
  `bodyHtml` text NOT NULL,
  `bodyText` text NOT NULL,
  `alias` varchar(255) NOT NULL,
  `fromEmail` varchar(255) DEFAULT NULL,
  `fromName` varchar(255) DEFAULT NULL,
  `signature` enum('true','false') NOT NULL DEFAULT 'true',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `description`, `subject`, `bodyHtml`, `bodyText`, `alias`, `fromEmail`, `fromName`, `signature`) VALUES
(5, 'User registration letter', 'Registration on %host%', 'Please, confirm your registration<br/><br/>Click the folowing link:<br/><a href="http://%host%/users/register/confirm-registration/hash/%hash%">http://%host%/users/register/confirm-registration/hash/%hash%</a><br />With best regards,<br /><a href="http://%host%/>%host% team</a>', 'Please confirm your registration\\n\\nOpen the folowing link in your browser: \\nhttp://%host%/users/register/confirm-registration/hash/%hash%\n\n\nWith best regards,\n%host% team', 'registration', NULL, NULL, 'true'),
(6, 'User forget password letter', 'Forget password on %host%', 'You''re ask to reset your password.<br/><br/>Please confirm that you wish to reset it clicking on the url:<br /><a href="http://%host%/users/login/recover-password/hash/%hash%/">http://%host%/users/login/recover-password/hash/%hash%/</a><br/><br/>If this message was created due to mistake, you can cancel password reset via next link:<br /><a href="http://%host%/users/login/cancel-password-recovery/hash/%hash%/">\nhttp://%host%/users/login/cancel-password-recovery/hash/%hash%/</a><br />With best regards,<br /><a href="http://%host%/>%host% team</a>', 'You''re ask to reset your password.\\n\\nPlease confirm that you wish to reset it clicking on the url:\\nhttp://%host%/users/login/recover-password/hash/%hash%/\\n\\nIf this message was created due to mistake, you can cancel password reset via next link:\\nhttp://%host%/users/login/cancel-password-recovery/hash/%hash%/\n\n\nWith best regards,\n%host% team', 'forgetPassword', NULL, NULL, 'true'),
(7, '', 'New password for %host%', 'You''re ask to reset your password.<br/><br/>Your new password is:<br /><b>%password%</b><br />With best regards,<br /><a href="http://%host%/">%host% team</a>', 'You''re ask to reset your password.\n\nYour new password is:\n%password%\n\n\nWith best regards,\n%host% team', 'newPassword', NULL, NULL, 'true'),
(8, NULL, 'Thank you for your letter', 'Thank you for your letter!<br />With best regards,<br /><a href="http://%host%/">%host% team</a>', 'Thank you for your letter!\n\n\nWith best regards,\n%host% team', 'reply', NULL, NULL, 'true');
