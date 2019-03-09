#!/bin/bash
cd /var/www/
chmod -R 777 html
gunzip users.csv.gz
php /var/www/html/artisan import:CSV &
apache2-foreground