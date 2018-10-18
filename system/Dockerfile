FROM victorhbfernandes/php-fpm-nginx-mongo:7.1.17


COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/fpm-pool.conf /etc/php7/php-fpm.d/zzz_custom.conf
COPY conf/php.ini /etc/php7/conf.d/zzz_custom.ini
COPY conf/supervisord.conf.local /etc/supervisor/conf.d/supervisord.conf

RUN mkdir -p /app
WORKDIR /app

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

COPY ../lista_relevancia_1.txt /app/storage/app/lista_relevancia_1.txt;
COPY ../lista_relevancia_2.txt /app/storage/app/lista_relevancia_2.txt;

