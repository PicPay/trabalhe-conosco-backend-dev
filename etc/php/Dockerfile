FROM php:7.2-fpm

RUN docker-php-ext-install pdo pdo_mysql
COPY ./php_memory_limit.ini /usr/local/etc/php/conf.d/php_memory_limit.ini