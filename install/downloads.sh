#!/bin/bash
chmod -R 777 /opt/lampp/htdocs/db/
wget 'https://s3.amazonaws.com/careers-picpay/users.csv.gz'
mv users.csv.gz /opt/lampp/htdocs/db/users.csv.gz