#!/bin/sh

# Roda o container MySql com o banco de dados 'users' e credenciais para usuario users-service para acesso
echo "Starting DB..."  
docker run --name db -d \  
  -e MYSQL_ROOT_PASSWORD=123 \
  -e MYSQL_DATABASE=users -e MYSQL_USER=users_service -e MYSQL_PASSWORD=123 \
  -p 3306:3306 \
  mysql:latest

# Espera o banco inciiar.
echo "Waiting for DB to start up..."  
docker exec db mysqladmin --silent --wait=30 -uusers_service -p123 ping || exit 1

# Roda o script setup.sql.
echo "Setting up initial data..."  
docker exec -i db mysql -uusers_service -p123 users < setup.sql  

