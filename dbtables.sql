-- phpMyAdmin SQL Dump
-- version 3.4.2
-- http://www.phpmyadmin.net


SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Resume`
--
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `APPLICANT_DETAILS` (
  `name` varchar(30) NOT NULL,
  `email_applicant` varchar(32) DEFAULT NULL,
  `contact` varchar(10) NOT NULL,
  `address_applicant` varchar(32) DEFAULT NULL,
  `sex_applicant` tinyint(1) unsigned NOT NULL,   
  `experience1_applicant` int(11) unsigned NOT NULL,
  `experience2_applicant` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `clients_handled` varchar(50) DEFAULT NULL,
  `skills_applicant` varchar(32) NOT NULL,
  `achievements_applicant` int(11) NOT NULL,
  `extra_information` varchar(100) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`email_applicant`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

