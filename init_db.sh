#!bin/bash

wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
wget https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt
wget https://s3.amazonaws.com/careers-picpay/users.csv.gz
gunzip users.csv.gz

sudo chmod 777 /var/lib/mysql-files/

sudo mv users.csv /var/lib/mysql-files/
sudo mv lista_relevancia_1.txt /var/lib/mysql-files/
sudo mv lista_relevancia_2.txt /var/lib/mysql-files/

mysql -u root -ppicpay123 < init_db.sql
