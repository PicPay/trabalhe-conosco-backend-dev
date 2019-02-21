FROM infra_kafka

COPY worker.properties /tmp/worker.properties
COPY distributed-worker.properties /tmp/distributed-worker.properties
COPY file-stream.properties /tmp/file-stream.properties
COPY elastic-sink.properties /tmp/elastic-sink.properties
COPY kafka-connect-spooldir.tar.gz /tmp/plugins/kafka-connect-spooldir.tar.gz
COPY kafka-connect-elasticsearch.tar.gz /tmp/plugins/kafka-connect-elasticsearch.tar.gz
#Setup
RUN mkdir -p /tmp/plugins/kafka-connect-spooldir \
 && mkdir -p /tmp/plugins/kafka-connect-elasticsearch \
 && tar -xzvf /tmp/plugins/kafka-connect-spooldir.tar.gz -C /tmp/plugins/kafka-connect-spooldir/ \
 && tar -xzvf /tmp/plugins/kafka-connect-elasticsearch.tar.gz -C /tmp/plugins/kafka-connect-elasticsearch/ \
 && curl https://s3.amazonaws.com/careers-picpay/users.csv.gz --output /tmp/users.csv.gz \
 && gzip -d /tmp/users.csv.gz \
 && mkdir -p /tmp/in \
 && mkdir -p /tmp/out \
 && mkdir -p /tmp/err \
 && mv /tmp/users.csv /tmp/in/users.csv
#Topic config
#CMD connect-distributed.sh /tmp/distributed-worker.properties
CMD connect-standalone.sh /tmp/worker.properties /tmp/file-stream.properties /tmp/elastic-sink.properties