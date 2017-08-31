#!bin/bash

wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt
wget https://s3.amazonaws.com/careers-picpay/users.csv.gz
gunzip users.csv.gz

sudo mv users.csv /db
sudo mv lista_relevancia_1.txt /db
sudo mv lista_relevancia_2.txt /db
