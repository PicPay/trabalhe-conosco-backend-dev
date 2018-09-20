CREATE DATABASE IF NOT EXISTS picpay;
USE picpay;

CREATE TABLE IF NOT EXISTS users (id varchar(255) DEFAULT NULL, name varchar(100) DEFAULT NULL, username varchar(100) DEFAULT NULL);

LOAD DATA INFILE "/var/lib/mysql-files/users.csv" INTO TABLE users COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' (id, name, username);