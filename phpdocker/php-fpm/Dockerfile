FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install  php7.2-mysql php7.2-pgsql php-redis php7.2-sqlite3 php7.2-bz2 php-imagick php7.2-imap php7.2-intl php7.2-odbc php7.2-phpdbg php7.2-snmp php7.2-soap php-ssh2 php7.2-xmlrpc php7.2-xsl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*