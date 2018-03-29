#!/usr/bin/env bash

./cli/console.sh doctrine:migrations:migrate --no-interaction

./cli/console.sh "app:import-users"