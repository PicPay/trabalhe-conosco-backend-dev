# Versao mysql 5
FROM mysql:5

# Inserindo dados do banco
ENV MYSQL_ROOT_PASSWORD picpay123
ENV MYSQL_DATABASE db_picpay
ENV MYSQL_USER user_db
ENV MYSQL_PASSWORD picpay123

RUN chmod 777 /var/lib/mysql-files/

ADD users.csv /var/lib/mysql-files/
ADD lista_relevancia_1.txt /var/lib/mysql-files/
ADD lista_relevancia_2.txt /var/lib/mysql-files/

ADD init_db.sql /docker-entrypoint-initdb.d

RUN /etc/init.d/mysql start