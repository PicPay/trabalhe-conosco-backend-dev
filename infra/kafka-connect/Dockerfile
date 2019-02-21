FROM infra_kafka

expose 8086
VOLUME ["/tmp"]

CMD connect-standalone.sh /tmp/worker.properties /tmp/file-stream.properties