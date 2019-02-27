#!/bin/sh
php /var/www/html/artisan import:DB &
apache2-foreground