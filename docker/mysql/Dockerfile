FROM mysql:5.7.19

RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

ADD db_picpay.sql /docker-entrypoint-initdb.d/db_picpay.sql

CMD ["mysqld"]

EXPOSE 3306
