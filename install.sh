#!/usr/bin/env bash

echo '### Downloading the database dump ###';
mkdir app/Sources && wget "https://s3.amazonaws.com/careers-picpay/users.csv.gz" --directory-prefix=app/Sources

echo '### Extracting the dump file ###'
gunzip app/Sources/users.csv.gz && mv app/Sources/users.csv app/Sources/users_picpay.csv

echo '### Fixing wrong names ###'
docker exec -it laradock_workspace_1 php app/Misc/FixWrongName.php

echo '### Downloading relevancies lists ###'
wget "https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt" --directory-prefix=app/Sources
wget "https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt" --directory-prefix=app/Sources

echo '### Copying the env-example to .env in laradock ###'
cp laradock/env-example laradock/.env

echo '### Downloading and Turning on your docker containers ###';
cd laradock && docker-compose up -d nginx mysql phpmyadmin workspace redis

echo '### Running composer install ###';
docker exec -it laradock_workspace_1 composer install

echo '### Importing dump into our database ###'
docker exec -it laradock_mysql_1 mysqlimport -uroot -proot  --fields-terminated-by=, --verbose --local -p default /var/www/app/Sources/users_picpay.csv

echo '### Creating the index into users_picpay table ###'
docker exec -it laradock_mysql_1 mysql -uroot -proot -e "USE default; CREATE INDEX index_users_picpay ON users_picpay (id);"
docker exec -it laradock_mysql_1 mysql -uroot -proot -e "USE default; CREATE INDEX index_users_picpay_name ON users_picpay (name);"
docker exec -it laradock_mysql_1 mysql -uroot -proot -e "USE default; CREATE INDEX index_users_picpay_username ON users_picpay (username);"
docker exec -it laradock_mysql_1 mysql -uroot -proot -e "USE default; CREATE INDEX index_users_picpay_relevance ON users_picpay (relevance);"

echo '### Seeding the database with relevance of the users ###'
docker exec -it laradock_workspace_1 php artisan db:seed

echo '### Well done! access http://localhost and enjoy! ###'
