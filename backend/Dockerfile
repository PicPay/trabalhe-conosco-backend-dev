FROM maven:3.5.0-jdk-8

RUN useradd --user-group --create-home --shell /bin/false app

WORKDIR /home/app/backend

COPY ./pom.xml pom.xml
COPY ./src src/

RUN mvn clean package
EXPOSE 8080

CMD ["java", "-jar", "target/demo-0.0.1-SNAPSHOT.jar"]
