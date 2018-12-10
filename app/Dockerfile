#FROM alpine:3.8 as dwnldr
#
#RUN apk --update add wget \
#     gzip

#RUN wget "http://res.cloudinary.com/dbgv8nukd/raw/upload/v1537738980/picpay/users.csv.gz"
#RUN wget "https://s3.amazonaws.com/careers-picpay/users.csv.gz"

#RUN gunzip users.csv.gz
#RUN cp users.csv /tmp
#RUN mv users.csv /tmp

FROM maven:3.5-jdk-8

#COPY --from=dwnldr /tmp /tmp

#RUN ls /tmp