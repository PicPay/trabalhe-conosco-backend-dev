#!/bin/sh

if [ ! -e /db_seed/.seed-lock ]; then
  echo "Remove database ..."
  mongo db/picpay --eval "db.dropDatabase()"

  echo "Create admins indexes"
  mongo db/picpay --eval "db.admins.createIndex({ 'email': 1 }, { 'unique': true })"

  echo "Download lista_relevancia_1.txt ..."
  wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt -P /tmp

  echo "Download lista_relevancia_1.txt ..."
  wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt -P /tmp

  echo "Download users.csv.gz ..."
  wget https://s3.amazonaws.com/careers-picpay/users.csv.gz -P /tmp
  gunzip /tmp/users.csv.gz

  echo "Import priority lists ..."
  mongoimport -h db -d picpay -c list_1 --type csv --file /tmp/lista_relevancia_1.txt --fields id
  mongoimport -h db -d picpay -c list_2 --type csv --file /tmp/lista_relevancia_2.txt --fields id

  echo "Import documents in a new database ..."
  mongoimport -h db -d picpay -c users --type csv --file /tmp/users.csv --fields id,name,username

  echo "Create other indexes"
  mongo db/picpay --eval "db.list_1.createIndex({ 'id': 1 }, { 'unique': true })"
  mongo db/picpay --eval "db.list_2.createIndex({ 'id': 1 }, { 'unique': true })"
  mongo db/picpay --eval "db.users.createIndex({ 'username': 'text' }, { 'unique': true })"
  mongo db/picpay --eval "db.users.createIndex({ 'name': 'text' })"


  if [ -e /tmp/users.csv ] && [ -e /tmp/lista_relevancia_1.txt ] && [ -e /tmp/lista_relevancia_2.txt ]; then
    # If you want reseed database, remove /db_seed/.seed-lock
    touch /db_seed/.seed-lock
  fi
fi
