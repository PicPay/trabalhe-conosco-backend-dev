# Versao mysql 5
FROM mysql:5

# Inserindo dados do banco
ENV MYSQL_ROOT_PASSWORD 123  
ENV MYSQL_DATABASE users  
ENV MYSQL_USER users_service  
ENV MYSQL_PASSWORD 123


ADD setup.sql /docker-entrypoint-initdb.d  
