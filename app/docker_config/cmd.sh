#!/bin/sh

# Tweak nginx to match the workers to cpu's
procs=$(cat /proc/cpuinfo | grep processor | wc -l)
sed -i -e "s/worker_processes 5/worker_processes $procs/" /etc/nginx/nginx.conf

chmod -R 777 /app/storage
chmod -R 777 /app/bootstrap/cache

# Start supervisord and services
supervisord -n -c /etc/supervisord.conf