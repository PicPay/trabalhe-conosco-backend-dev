FROM mysql:5.7

COPY ./users.csv /var/lib/mysql-files/users.csv
COPY ./000_init.sql /docker-entrypoint-initdb.d/000_init.sql