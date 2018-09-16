FROM mongo
RUN apt-get -qq update && apt-get -qq -y install curl
COPY users.csv /users.csv
CMD mongoimport --host mongo --db picpay --collection users --type csv --file /users.csv --fields "id,name,username" \
&& curl http://nginx:80/config.php
# && php -d xdebug.remote_autostart=1 /var/www/html/config.php
#CMD php -d xdebug.remote_autostart=1 /var/www/html/config.php