DROP TABLE IF EXISTS tb_user;
CREATE TABLE tb_user(id varchar(255), name varchar(255), username varchar(255)) AS SELECT * FROM CSVREAD('classpath:/users.csv', 'id,name,username', null) ;
CREATE INDEX idxname ON tb_user(name, username);
ALTER TABLE tb_user ADD priority int DEFAULT 10;
CREATE INDEX idxpriority ON tb_user(priority);
