CREATE TABLE credentials (
	    username character varying(64) NOT NULL,
	    password character varying(128)
);
 
ALTER TABLE credentials OWNER TO picpay;
 
CREATE TABLE list_1 (
	    id character(36) NOT NULL
);
 
ALTER TABLE list_1 OWNER TO picpay;
 
CREATE TABLE list_2 (
	    id character(36) NOT NULL
);

ALTER TABLE list_2 OWNER TO picpay;
 
CREATE TABLE "user" (
	    id character(36) NOT NULL,
	    name text NOT NULL,
	    username text NOT NULL
);
 
ALTER TABLE "user" OWNER TO picpay;
 
ALTER TABLE ONLY credentials
    ADD CONSTRAINT credentials_pkey PRIMARY KEY (username);
 
ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 
COPY public.user FROM '/docker-entrypoint-initdb.d/users.csv' WITH (FORMAT csv);
COPY public.list_1 FROM '/docker-entrypoint-initdb.d/lista_relevancia_1.csv' WITH (FORMAT csv);
COPY public.list_2 FROM '/docker-entrypoint-initdb.d/lista_relevancia_2.csv' WITH (FORMAT csv);

ALTER TABLE public.user ADD COLUMN weight smallint, ADD COLUMN tsv tsvector;

UPDATE public.user SET tsv = to_tsvector(name || ' ' || username);
UPDATE public.user SET weight = 2 WHERE id IN (SELECT id FROM list_2);
UPDATE public.user SET weight = 1 WHERE id IN (SELECT id FROM list_1);

CREATE INDEX gist_tsv_index ON "user" USING gist (tsv);

DROP TABLE list_1;
DROP TABLE list_2;
