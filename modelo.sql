create schema picpay;

CREATE TABLE IF NOT EXISTS picpay.users (
   ID varchar(255) CONSTRAINT ID PRIMARY KEY,
   NOME varchar(255),
   USERNAME varchar(255)
);

CREATE TABLE IF NOT EXISTS PICPAY.PRIORIDADE1 (
    ID  VARCHAR(255) PRIMARY KEY REFERENCES picpay.users(ID)
);

CREATE TABLE IF NOT EXISTS PICPAY.PRIORIDADE2 (
    ID  VARCHAR(255) PRIMARY KEY REFERENCES picpay.users(ID)
);
