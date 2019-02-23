#!/bin/bash
docker-compose -f ./infra/docker-compose.yml down
docker-compose -f ./infra/docker-compose.yml up -d --build zookeeper kafka

docker-compose -f ./infra/docker-compose.yml up -d --build elasticsearch
echo "Wait for ElasticSearch"
bash -c 'while [[ "$(curl -s -o /dev/null -w ''%{http_code}'' localhost:9200)" != "200" ]]; do sleep 1; echo "#"; done; echo "done"'

docker-compose -f ./infra/docker-compose.yml up -d --build connect


docker run -it --rm --name java -v "$(pwd)":/usr/src/app -w /usr/src/app maven:slim mvn clean install
docker-compose -f ./infra/docker-compose.yml up -d --build app
