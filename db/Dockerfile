FROM postgres
WORKDIR /docker-entrypoint-initdb.d/
RUN apt-get update
RUN apt-get install curl -y
RUN curl -o users.csv.gz https://s3.amazonaws.com/careers-picpay/users.csv.gz
RUN gunzip users.csv.gz
RUN curl -o lista1.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_1.txt
RUN curl -o lista2.csv https://raw.githubusercontent.com/PicPay/trabalhe-conosco-backend-dev/master/lista_relevancia_2.txt
ADD init.sql /docker-entrypoint-initdb.d/
ENV POSTGRES_USER docker
ENV POSTGRES_PASSWORD docker
ENV POSTGRES_DB docker
EXPOSE 5432
