#!/bin/sh
cd /var/www/
gunzip users.csv.gz
php /var/www/html/artisan import:DB &
apache2-foreground