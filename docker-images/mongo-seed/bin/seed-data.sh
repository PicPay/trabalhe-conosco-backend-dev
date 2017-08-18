#!/bin/bash
if [[ ! -f /dataimport.lock && ! -f /mongo-seed/dataimport.lock ]]; then #so executa  na primeira inicializacao do container
  if [[ ! -f /mongo-seed/users.csv.gz && ! -f /mongo-seed/users.csv ]]; then #se nao tiver a base de dados
    wget -P /mongo-seed https://s3.amazonaws.com/careers-picpay/users.csv.gz
    gzip -d /mongo-seed/users.csv.gz
  else
    if [ ! -f /mongo-seed/users.csv ]; then # se tiver somente o compacto
      gzip -d /mongo-seed/users.csv.gz
    fi
  fi
  mongoimport --host app_mongodb --db picpay --collection users --type csv --file /mongo-seed/users.csv --fields "id,name,username"
  mongo app_mongodb/picpay --eval "db.users.update({},{\$set: { lista1: 0, lista2: 0 }},{ multi:true })" #cria compo de lista de relevancia
  mongo app_mongodb/picpay --eval "db.users.createIndex( { id: 1, tags: 1 } )"  #indexa valores de id e tags
  touch /dataimport.lock #criando lock para nao executar novamente
  touch /mongo-seed/dataimport.lock #criando lock para nao executar novamente
  rm /import.lock #terminou de importar
fi
