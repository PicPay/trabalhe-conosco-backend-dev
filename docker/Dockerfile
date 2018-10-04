FROM php:7.0-apache
COPY config/php.ini /usr/local/etc/php/

ARG TZ=America/Sao_Paulo
ENV TZ ${TZ}

RUN a2enmod headers
RUN a2enmod rewrite
COPY config/slim.conf /etc/apache2/sites-enabled/000-default.conf
#RUN mkdir -p /var/opt/fsbusiness/logs && chmod 777 -R /var/opt/fsbusiness/logs

RUN apt-get update && \
    apt-get install -y libxml2-dev git curl && \
    docker-php-ext-install soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer