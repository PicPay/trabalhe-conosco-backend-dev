FROM php:7.1.1-fpm
#RUN docker-php-ext-install mysqli pdo_mysql

# WITH MONGO DB
#FROM php:7.1.1

RUN apt-key adv --keyserver hkp://keyserver.ubuntu.com:80 --recv EA312927 \
  && echo "deb http://repo.mongodb.org/apt/debian wheezy/mongodb-org/3.2 main" | tee /etc/apt/sources.list.d/mongodb-org-3.2.list \
  && apt-get update \ 
  && apt-get install -y mongodb-org --no-install-recommends \
  && apt-get install -y libssl-dev unzip \
  && pecl install mongodb \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && docker-php-ext-enable mongodb \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
