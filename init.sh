#!/bin/bash
docker-compose up -d
docker exec -it testpicpay_robsong /opt/lampp/xampp start
cp ./lista_relevancia_1.txt app/db/
cp ./lista_relevancia_2.txt app/db/

if [[ ! -f app/db/users.csv && ! -f app/db/users.csv.gz ]]; then
    docker exec -it testpicpay_robsong /install/downloads.sh
fi

if [ -f app/db/users.csv.gz ]; then
    docker exec -it testpicpay_robsong gzip -d /opt/lampp/htdocs/db/users.csv.gz
fi

echo "======================================================="
echo "======================================================="
echo "Configurações padrão da aplicaçao"
echo "usuario: picpay"
echo "senha: picpay"
echo "acesse http://localhost:3737"
echo "======================================================="
echo "======================================================="
echo "--------------------Instalando o banco-----------------"
echo "======================================================="
echo "Isso pode levar de 10 a 20 minutos"

sleep 5
docker exec -it testpicpay_robsong /opt/lampp/htdocs/db/install_sql.sh
