FROM alpine:3.8 as dwnldr

RUN apk --update add wget \
     gzip

RUN wget "https://s3.amazonaws.com/careers-picpay/users.csv.gz" -P /tmp/
RUN gunzip /tmp/users.csv.gz

FROM mysql:8.0.13

COPY --from=dwnldr /tmp/users.csv /tmp/users.csv

RUN chmod -R 777 /tmp/users.csv
