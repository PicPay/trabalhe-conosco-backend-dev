LOAD DATA INFILE "\ApiRestfullpic\db\users.csv" INTO TABLE users COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' (guid, nome, userName);
