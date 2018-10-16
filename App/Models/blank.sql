SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE DATABASE `blank` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `blank`;


CREATE TABLE `users` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`email` varchar(255) NOT NULL UNIQUE,
	`password` varchar(64) NOT NULL,
	`joindate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`confirm_date` datetime DEFAULT NULL,
	`confirm_token` varchar(32) DEFAULT NULL,
	`reset_date` datetime DEFAULT NULL,
	`reset_token` varchar(32) DEFAULT NULL,
	`last_login` datetime DEFAULT NULL,
	`last_ip` varchar(15) DEFAULT NULL,
	`level` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;