FROM alpine:3.8

RUN apk --update add --no-cache \
        nginx \
        curl \
        supervisor \
        php7 \
        php7-dom \
        php7-fpm \
        php7-mbstring \
        php7-mcrypt \
        php7-opcache \
        php7-pdo \
        php7-pdo_mysql \
        php7-xml \
        php7-simplexml \
        php7-phar \
        php7-openssl \
        php7-json \
        php7-curl \
        php7-ctype \
        php7-session \
        php7-gd \
        php7-tokenizer \
        php7-xmlwriter \
    && mv /usr/bin/php /usr/bin/php2 \
    && ln -s /usr/bin/php7 /usr/bin/php \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && mkdir -p /app \
    && addgroup -g 1000 -S www \
    && adduser -u 1000 -D -S -G www -h /app -g www www \
    && chown -R www:www /var/lib/nginx \
    && chown -R www:www /var/tmp/nginx

COPY /docker_config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY /docker_config/nginx/default /etc/nginx/sites-enabled/default

COPY /docker_config/php/php.ini /etc/php7/php.ini
COPY /docker_config/php/www.conf /etc/php7/php-fpm.d/www.conf

COPY /docker_config/supervisord.conf /etc/supervisord.conf


COPY ./ ./app

WORKDIR /app

ADD /docker_config/cmd.sh /cmd.sh

RUN chmod +x /cmd.sh

RUN composer install

CMD ["/cmd.sh"]