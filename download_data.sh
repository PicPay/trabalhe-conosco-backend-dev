#!/bin/bash
# Verifica se o arquivo já existe, se não o baixa e extrai
if ! [ -f ./etc/mysql/users.csv ]; then
  curl https://s3.amazonaws.com/careers-picpay/users.csv.gz --output ./etc/mysql/users.csv.gz
  gunzip ./etc/mysql/users.csv.gz
else
  echo "O Arquivo já está baixado! O mesmo se encontra em ./etc/mysql/users.csv"
fi