load data local infile '/tmp/users.csv' into table users
 fields terminated by ','
 enclosed by '"'
 lines terminated by '\r\n'
 (id, name, userName);

