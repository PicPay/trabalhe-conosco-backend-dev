FROM java:8
VOLUME /tmp

ARG  APP_JAR=./target/picpay-users-0.0.1-SNAPSHOT.jar
COPY ${APP_JAR} app.jar
COPY ./lista_relevancia_1.txt lista_relevancia_1.txt
COPY ./lista_relevancia_2.txt lista_relevancia_2.txt
COPY ./public public
COPY ./wait-for-it.sh wait-for-it.sh

ARG  USERS_CSV=./users.csv
COPY ${USERS_CSV} users.csv

ENV  ELASTICSEARCH_ADDRESS=127.0.0.1

EXPOSE 8082

CMD ["./wait-for-it.sh", "--host=elasticsearch", "--port=9200", "--timeout=40", "--" ,"java", "-jar", "app.jar", "--elasticsearch.address=${ELASTICSEARCH_ADDRESS}"]
