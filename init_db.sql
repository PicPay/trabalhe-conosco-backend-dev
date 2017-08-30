CREATE DATABASE db_picpay;

use db_picpay;

CREATE TABLE usuarios ( id varchar(255) DEFAULT NULL, nome varchar(255) DEFAULT NULL, username varchar(255) DEFAULT NULL ) DEFAULT CHARSET=latin1;

LOAD DATA INFILE "/var/lib/mysql-files/users.csv" INTO TABLE usuarios COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' (id, nome, username);

CREATE TABLE `autenticacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) DEFAULT CHARSET=latin1;

CREATE TABLE `relevancia_1` (
  `id` varchar(255) DEFAULT NULL
) DEFAULT CHARSET=latin1;

CREATE TABLE `relevancia_2` (
  `id` varchar(255) DEFAULT NULL
) DEFAULT CHARSET=latin1;

LOAD DATA INFILE "/var/lib/mysql-files/lista_relevancia_1.txt" INTO TABLE relevancia_1 COLUMNS TERMINATED BY '\n' LINES TERMINATED BY '\n' (id);

LOAD DATA INFILE "/var/lib/mysql-files/lista_relevancia_2.txt" INTO TABLE relevancia_2 COLUMNS TERMINATED BY '\n' LINES TERMINATED BY '\n' (id);

quit
