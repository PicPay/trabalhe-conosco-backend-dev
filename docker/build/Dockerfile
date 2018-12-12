FROM openjdk:8-jdk-alpine
VOLUME /tmp
ARG JAR_FILE=api-1.0.jar
COPY ${JAR_FILE} app.jar
ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-Dspring.profiles.active=container","-jar","/app.jar"]
