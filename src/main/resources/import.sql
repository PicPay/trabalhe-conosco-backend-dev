--INSERT INTO tb_user SELECT * FROM CSVREAD('classpath:/users.csv', 'id,name,username', null) WHERE name like '%Rafael%';
DROP TABLE IF EXISTS tb_user;
CREATE TABLE tb_user(id varchar(255), name varchar(255), username varchar(255)) AS SELECT * FROM CSVREAD('classpath:/users.csv', 'id,name,username', null);

--LOAD DATA LOCAL INFILE 'C:\\ProgramData\\MySQL\\MySQL Server 8.0\\Uploads\\users.csv' INTO TABLE tb_user;