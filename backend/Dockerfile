FROM openjdk:8-alpine

COPY wtfc.sh /opt/backend/

RUN chmod +x /opt/backend/wtfc.sh

COPY target/backend-1.0-SNAPSHOT.jar /opt/backend/backend-1.0-SNAPSHOT.jar

EXPOSE 8080

CMD java -jar /opt/backend/backend-1.0-SNAPSHOT.jar
