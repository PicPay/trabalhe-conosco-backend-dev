wget -c https://s3.amazonaws.com/careers-picpay/users.csv.gz
gzip -d users.csv.gz
mv users.csv  src/main/resources/
docker-compose build
docker-compose up
