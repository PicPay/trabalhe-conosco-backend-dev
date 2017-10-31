FROM php:7-apache

ENV http_proxy ${http_proxy}
ENV https_proxy ${http_proxy}

RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        git \
    && docker-php-ext-install -j$(nproc) iconv mcrypt zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

COPY ./provisioning/php.ini /usr/local/etc/php/conf.d/timezone.ini
COPY ./provisioning/uploads.ini /usr/local/etc/php/conf.d/upload.ini
COPY ./provisioning/apache.conf /etc/apache2/sites-available/000-default.conf

CMD usermod -u 1000 www-data \
    && cd /var/www/html && composer install && rm -rf var/cache/*  \
    && chown -R www-data:www-data /var/www/html/var/cache && chmod 777 /var/www/html/var/cache \
    && apache2-foreground

EXPOSE 80