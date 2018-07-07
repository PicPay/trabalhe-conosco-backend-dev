
CREATE DATABASE picpay;
use picpay;
-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 05-Jul-2018 às 23:58
-- Versão do servidor: 5.5.36
-- PHP Version: 5.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `acesso`
--

CREATE TABLE IF NOT EXISTS `acesso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `api_code` varchar(36) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `acesso`
--

INSERT INTO `acesso` (`id`, `login`, `password`, `api_code`) VALUES
(1, 'picpay', '072c19d58aa4dc40388c1bc7f2a632be', 'de2adc98-78ee-f664-272a-cceb49c4a489');

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_relevancia`
--

CREATE TABLE IF NOT EXISTS `lista_relevancia` (
  `Id` varchar(36) NOT NULL,
  `relevancia` int(11) NOT NULL DEFAULT '0',
  KEY `id` (`Id`(10))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `Id` varchar(36) NOT NULL,
  `Nome` varchar(25) NOT NULL,
  `Username` varchar(20) NOT NULL,
  KEY `indices` (`Id`(10),`Nome`(10),`Username`(10))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_sem_indice`
--

CREATE TABLE IF NOT EXISTS `usuarios_sem_indice` (
  `Id` varchar(36) NOT NULL,
  `Nome` varchar(25) NOT NULL,
  `Username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



LOAD DATA INFILE "/opt/lampp/htdocs/db/lista_relevancia_1.txt"
INTO TABLE lista_relevancia
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n'
IGNORE 0 LINES;
UPDATE lista_relevancia set relevancia =1;

LOAD DATA INFILE "/opt/lampp/htdocs/db/lista_relevancia_2.txt"
INTO TABLE lista_relevancia
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\n'
IGNORE 0 LINES;




LOAD DATA INFILE "/opt/lampp/htdocs/db/users.csv"
INTO TABLE usuarios_sem_indice
COLUMNS TERMINATED BY ','
OPTIONALLY ENCLOSED BY '"'
ESCAPED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 0 LINES;
