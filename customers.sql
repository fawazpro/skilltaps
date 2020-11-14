-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `user_id` varchar(15) NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `sex` varchar(6) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `paid` binary(1) NOT NULL,
  `ref_id` varchar(15) NOT NULL,
  `address` mediumtext NOT NULL,
  `wallet` int(11) NOT NULL,
  `ref1` varchar(10) NOT NULL,
  `ref2` varchar(10) NOT NULL,
  `ref3` varchar(10) NOT NULL,
  `ref4` varchar(10) NOT NULL,
  `ref5` varchar(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2020-09-29 09:04:39
