#!/bin/bash

exec $(type -p java) -jar /opt/app.jar \
 --spring.data.jest.uri=http://elasticsearch:9200 \
 --spring.kafka.bootstrap-servers=kafka:9092 \
 --spring.kafka.consumer.bootstrap-servers=kafka:9092
