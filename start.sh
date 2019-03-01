#!/bin/bash

OS=`uname -s`
REV=`uname -r`
MACH=`uname -m`


if [ "${OS}" =  "Linux" ]; then
    docker_host_ip=$(hostname -I | awk '{print $1}')
    export DOCKER_HOST_IP=$docker_host_ip
elif [ "${OS}" = "Darwin" ]; then
    if [[ -z "${DOCKER_HOST_IP-}" ]]; then
        docker_host_ip=$(docker run --rm --net host alpine ip address show eth0 | awk '$1=="inet" {print $2}' | cut -f1 -d'/')
        if [[ $docker_host_ip = '192.168.65.2' ]]; then
            docker_host_ip=$(/sbin/ifconfig | grep -v '127.0.0.1' | awk '$1=="inet" {print $2}' | cut -f1 -d'/' | head -n 1)
        fi
        export DOCKER_HOST_IP=$docker_host_ip
    fi
fi
echo 'Getting ip: '$DOCKER_HOST_IP
docker-compose -f ./infra/docker-compose.yml down
docker-compose -f ./infra/docker-compose.yml up -d --build zookeeper kafka

docker-compose -f ./infra/docker-compose.yml up -d --build elasticsearch
echo "Wait for ElasticSearch"
bash -c 'while [[ "$(curl -s -o /dev/null -w ''%{http_code}'' localhost:9200)" != "200" ]]; do sleep 1; echo "#"; done; echo "done"'

docker-compose -f ./infra/docker-compose.yml up -d --build connect

docker run -it --rm --name java -v "$(pwd)":/usr/src/app -w /usr/src/app maven:slim mvn clean install

docker-compose -f ./infra/docker-compose.yml up -d --build app
