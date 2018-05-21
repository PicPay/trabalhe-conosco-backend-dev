CREATE DATABASE IF NOT EXISTS `picpay`;

CREATE TABLE IF NOT EXISTS `picpay`.`user` (
	`id` varchar(36) NOT NULL, 
	`name` varchar(200) NOT NULL, 
	`username` varchar(100) NOT NULL, 
PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `picpay`.`prior1` (
	`id` varchar(36) NOT NULL,
PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `picpay`.`prior2` (
	`id` varchar(36) NOT NULL,
PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;