#!/usr/bin/env bash

echo -e "\033[01;32m-------------- Iniciando o deploy -----------------------------------\033[01;37m";

echo -e "\033[01;32m--------------- Baixando Dump do Banco de Dados ----------------------\033[01;37m";

cp lista_relevancia_1.txt system/app/storage/app/lista_relevancia_1.txt
cp lista_relevancia_2.txt system/app/storage/app/lista_relevancia_2.txt

file="db/users.csv";

if [ -f "$file" ]
then
	echo -e "\033[01;31mO dump já foi baixado anteriormente.\033[01;37m";
else
	wget "https://s3.amazonaws.com/careers-picpay/users.csv.gz" --directory-prefix=db
	gunzip db/users.csv.gz
fi


echo -e "\033[01;32m-------------- Subindo o Docker -------------------------------------\033[01;37m";

docker-compose up -d

echo -e "\033[01;32m-------------- Instalando pendências do PHP -------------------------\033[01;37m";

docker exec -it app composer install

echo -e "\033[01;32m-------------- Criando Tabelas --------------------------------------\033[01;37m";

docker exec -it app php artisan migrate:refresh

echo -e "\033[01;32m-------------- Criando Usuário --------------------------------------\033[01;37m";

docker exec -it app php artisan user:save

echo "Usuario: admin@picpay.com
Senha: yapcip
Token Api: Bearer eWFwY2lw";

echo -e "\033[01;32m-------------- Liberando Log --------------------------------------\033[01;37m";

docker exec -it app chmod -R 777 storage/

echo -e "\033[01;32m-------------- Dump do Banco de Dados -------------------------------\033[01;37m";

docker exec -it mongo mongoimport -d admin -c clients --type csv --file /home/users.csv --fields "ident,name,user" --authenticationDatabase admin --username 'picpay' --password 'yapcip'

echo -e "\033[01;32m-------------- Atualizando Relevancia --------------------------------------\033[01;37m";

docker exec -it app php artisan save:relevance

echo -e "\033[01;32m-------------- Finalizado -------------------------------\033[01;37m";

echo "

Link do frontend: http://localhost:9090
Endpoint da api: http://localhost:9090/api/list?search=&page=

Usuário: admin@picpay.com
Senha: yapcip
Token Api: Bearer eWFwY2lw";






