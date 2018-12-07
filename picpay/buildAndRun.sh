wget -c https://s3.amazonaws.com/careers-picpay/users.csv.gz
gzip -d users.csv.gz
mv users.csv  src/main/resources/
mvn clean package -DskipTests
docker-compose build
docker-compose up
