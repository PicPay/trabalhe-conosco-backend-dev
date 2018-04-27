#!/bin/bash
docker-compose run --rm front yarn install
./cli/composer.sh install
docker-compose start
