FROM alpine:3.8 as getter

RUN apk --update add wget \
     gzip
#Teste com a base reduzida
# RUN wget "http://res.cloudinary.com/dbgv8nukd/raw/upload/v1537738980/picpay/users.csv.gz"
RUN wget "https://s3.amazonaws.com/careers-picpay/users.csv.gz"

RUN gunzip users.csv.gz
RUN mv users.csv /tmp

FROM mysql:5.7

COPY --from=getter /tmp /tmp