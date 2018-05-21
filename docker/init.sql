\c picpay;
CREATE SCHEMA IF NOT EXISTS picpay;

CREATE TABLE picpay.user (  
   id VARCHAR(36) PRIMARY KEY,
   name VARCHAR(100),
   username VARCHAR(100)
);
CREATE TABLE picpay.prior1 (  
   id VARCHAR(36) PRIMARY KEY
);
CREATE TABLE picpay.prior2 (  
   id VARCHAR(36) PRIMARY KEY
);

COPY picpay.user FROM '/docker-entrypoint-initdb.d/users.csv' CSV;
COPY picpay.prior1 FROM '/docker-entrypoint-initdb.d/lista1.csv' CSV;
COPY picpay.prior2 FROM '/docker-entrypoint-initdb.d/lista2.csv' CSV;