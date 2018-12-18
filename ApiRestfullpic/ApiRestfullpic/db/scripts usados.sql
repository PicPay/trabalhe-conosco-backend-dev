CREATE TABLE `users` (
`id` int8 unsigned not null auto_increment,
`guid` varchar(36) NOT NULL,
`nome` varchar(50) NOT NULL,
`userName` varchar(50) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB;

LOAD DATA INFILE "C:/laragon/data/mysql/users.csv" INTO TABLE users COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\r\n' (guid, nome, userName);
<!-- 160 segs para importar os dados

create table `order1`(
	`id` varchar(255) null
);

create table `order2`(
	`id` varchar(255) null
);

load data infile 'C:/laragon/data/mysql/lista_relevancia_1.txt' into table ORDER1 COLUMNS TERMINATED BY '\n' LINES TERMINATED BY '\n' (id);

load data infile 'C:/laragon/data/mysql/lista_relevancia_2.txt' into table ORDER2 COLUMNS TERMINATED BY '\n' LINES TERMINATED BY '\n' (id);

<!-- migrations
-----------------------------------------------------------
<!-- testes sql

select * from users where id=156234;

select * from order1;

select * from users where guid like '7354ff5e-cc72-4cc7-a8d0-279f3349c52b'; <!-- 1116175

select * from users where guid like	'f1c01392-84e0-4dc5-9ab5-cf66c94f5b0f'; <!-- 798015

select * from users where guid like '293db107-5536-40ea-b8d9-dfb9244f4500'; <!-- 856017

select * from users as u where  u.nome like '%blandina%' && u.userName like '%blandina%' order by field(guid,(select id from order1 where id = u.guid),(select id from order2 where id = u.guid)) desc;


select * from users as u where 1 = 1 and u.nome like 'jarbas' = (select id from order1 where id = u.guid) &&  u.userName like 'jarbas' = (select id from order1 where id = u.guid);

select * from usuarios as u where nome like ? order by field (id, (select id from relevancia_1 where id = u.id)) desc, field (id, (select id from relevancia_2 where id = u.id))

select * from users as u where nome like ? order by field (guid, (select nome, userName from relevancia_1 where guid = u.guid)) desc, field (guid, (select guid from relevancia_2 where guid = u.guid)) desc, nome limit;

select nome,userName from users u where 1 = 1 and u.nome like 'maria' order by (select nome, userName from order1 where guid = u.guid)) 
		and u.userName like 'maria' 
order by field(nome,(select nome, userName from order1 where guid = u.guid)) nome limit;  

