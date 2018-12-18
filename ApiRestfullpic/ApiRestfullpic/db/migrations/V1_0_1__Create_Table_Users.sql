CREATE TABLE `users` (
`id` int8 unsigned not null auto_increment,
`guid` varchar(36) NOT NULL,
`nome` varchar(50) NOT NULL,
`usuario` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB;