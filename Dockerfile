FROM openjdk:8
ADD target/user-search.jar user-search.jar
EXPOSE 8086
ENTRYPOINT ["java", "-jar", "user-search.jar"]