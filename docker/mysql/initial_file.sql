
CREATE DATABASE `picpay` /*!40100 DEFAULT CHARACTER SET utf8 */;

CREATE TABLE `users` (
  `id` varchar(36) DEFAULT NULL,
  `nome` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `idx_name` (`nome`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `users_priority` (
  `id` varchar(36) NOT NULL,
  `priority` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `idx_priority` (`priority`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
