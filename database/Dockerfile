
FROM postgres
WORKDIR /docker-entrypoint-initdb.d/

RUN apt-get update
RUN apt-get install curl -y

RUN curl -L -o users.csv.gz https://s3.amazonaws.com/careers-picpay/users.csv.gz
RUN gzip -d users.csv.gz
RUN rm users.csv.gz
RUN curl -o lista_relevancia_1.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
RUN curl -o lista_relevancia_2.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt

COPY init.sql /docker-entrypoint-initdb.d/

ENV POSTGRES_USER picpay
ENV POSTGRES_PASSWORD picpay
ENV POSTGRES_DB picpay_db

EXPOSE 5432
