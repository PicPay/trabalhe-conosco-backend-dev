\c docker;
CREATE EXTENSION pg_trgm;
CREATE SCHEMA IF NOT EXISTS picpay;
CREATE TABLE picpay.registers(  
   id UUID PRIMARY KEY,
   name varchar(50),
   username varchar(50)
);

CREATE TABLE picpay.rank1(  
   id UUID PRIMARY KEY
);
CREATE TABLE picpay.rank2(  
   id UUID PRIMARY KEY
);
COPY picpay.registers FROM '/docker-entrypoint-initdb.d/users.csv' CSV;
COPY picpay.rank1 FROM '/docker-entrypoint-initdb.d/lista1.csv' CSV;
COPY picpay.rank2 FROM '/docker-entrypoint-initdb.d/lista2.csv' CSV;
-- CREATE INDEX name_index_text
--     ON picpay.registers USING btree
--     (name text_pattern_ops ASC NULLS LAST)
--     TABLESPACE pg_default;

CREATE INDEX tbl_col_gin_trgm_idx ON picpay.registers USING gin (name gin_trgm_ops);
CREATE INDEX tbl_col_gin_trgm_idz ON picpay.registers USING gin (username gin_trgm_ops);


-- CREATE INDEX username_index_text
--     ON picpay.registers USING btree
--     (username text_pattern_ops ASC NULLS LAST)
--     TABLESPACE pg_default;
