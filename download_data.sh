#!/bin/bash
# Verifica se o arquivo já existe, se não o baixa e extrai
if ! [ -f ./etc/elasticsearch/import_data/users.csv ]; then
  curl https://s3.amazonaws.com/careers-picpay/users.csv.gz --output ./etc/elasticsearch/import_data/users.csv.gz
  gunzip ./etc/elasticsearch/import_data/users.csv.gz
else
  echo "O Arquivo já está baixado! O mesmo se encontra em ./etc/elasticsearch/import_data/users.csv"
fi