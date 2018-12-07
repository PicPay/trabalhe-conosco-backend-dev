FROM java:8
VOLUME /tmp
EXPOSE 8080
ADD /target/picpay.jar app.jar

COPY /src/main/resources/lista_relevancia_1.txt lista_relevancia_1.txt
COPY /src/main/resources/lista_relevancia_2.txt lista_relevancia_2.txt
COPY /src/main/resources/users.csv users.csv



ENTRYPOINT ["java","-Dspring.data.mongodb.uri=mongodb://mongodb/picpay", "-jar", "app.jar"]
#ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]