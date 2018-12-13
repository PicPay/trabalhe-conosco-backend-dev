FROM openjdk:8-jre
MAINTAINER Rodrigo Vieira <rodrigovieirapinto@gmail.com>

ENTRYPOINT ["/usr/bin/java", "-jar", "/usr/share/app/app.jar"]

ARG JAR_FILE
ADD target/${JAR_FILE} /usr/share/app/app.jar
ADD target/classes/relevantes/lista_relevancia_1.txt /usr/share/app/relevantes/lista_relevancia_1.txt
ADD target/classes/relevantes/lista_relevancia_2.txt /usr/share/app/relevantes/lista_relevancia_2.txt