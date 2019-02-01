FROM openjdk:8-alpine

VOLUME /tmp
EXPOSE 8080

ADD build/libs/picuser.jar picuser.jar

ENTRYPOINT ["java","-jar","picuser.jar"]