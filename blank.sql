SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- -----------------------------------------------------------------------------

DROP DATABASE IF EXISTS `blank`;
CREATE DATABASE `blank` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `blank`;

-- -----------------------------------------------------------------------------

CREATE TABLE `users` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` varchar(255) NOT NULL UNIQUE,
	`password` varchar(64) NOT NULL,
	`joined_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
	`level` tinyint(4) NOT NULL DEFAULT '0',

	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -----------------------------------------------------------------------------

CREATE TABLE `logs` (
	`timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`user_id` int(11) UNSIGNED NOT NULL,
	`type` enum('registration', 'login', 'password_reset') NOT NULL,
	`data` text NULL,

	FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;