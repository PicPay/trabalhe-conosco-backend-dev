--INSERT INTO tb_user SELECT * FROM CSVREAD('classpath:/users.csv', 'id,name,username', null) WHERE name like '%Rafael%';
DROP TABLE IF EXISTS tb_user;
CREATE TABLE tb_user(id varchar(255), name varchar(255), username varchar(255)) AS SELECT * FROM CSVREAD('classpath:/users.csv', 'id,name,username', null) LIMIT 1000;
CREATE INDEX idxname ON tb_user(name, username);

--    SELECT * FROM foo
--    JOIN (VALUES (67,1), (23,2), (1362,3), (24,4)) as x(id, ordering) ON foo.id = x.id
--    ORDER BY x.ordering

--LOAD DATA LOCAL INFILE 'C:\\ProgramData\\MySQL\\MySQL Server 8.0\\Uploads\\users.csv' INTO TABLE tb_user;