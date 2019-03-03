#!/bin/bash
cd /var/www/
gunzip users.csv.gz
php /var/www/html/artisan import:CSV &
apache2-foreground