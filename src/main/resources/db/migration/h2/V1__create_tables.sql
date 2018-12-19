create sequence user_id_seq start with 1 increment by 1;
create sequence relevancia_id_seq start with 1 increment by 1;

create table users (
    id bigint DEFAULT nextval('user_id_seq') not null,
    hash varchar(100) not null,
    name varchar(255) not null,
    username varchar(255) not null,
    created_at timestamp,
    updated_at timestamp,
    primary key (id)
);

create table relevancia(
    id bigint DEFAULT nextval('relevancia_id_seq') not null,
	precedencia int,
	hash varchar(100)
);
