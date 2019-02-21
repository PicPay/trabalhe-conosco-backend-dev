#!/bin/bash
docker-compose -f ./infra/docker-compose.yml down
docker-compose -f ./infra/docker-compose.yml up -d --build elasticsearch
echo "Wait for ElasticSearch"
bash -c 'while [[ "$(curl -s -o /dev/null -w ''%{http_code}'' localhost:9200)" != "200" ]]; do sleep 1; echo "#"; done; echo "done"'

#./mvnw clean install


docker-compose -f ./infra/docker-compose.yml up -d --build