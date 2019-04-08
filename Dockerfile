FROM maven:3.6-jdk-11-slim

EXPOSE 7700

RUN mkdir -p /opt/dev/pp-backend/target
RUN chmod 777 -R /opt/dev/pp-backend/target

#Arquivos necessários para aplicação
COPY ./pp-backend/pom.xml /opt/dev/pp-backend/pom.xml
COPY ./pp-backend/src     /opt/dev/pp-backend/src

COPY ./pom.xml /opt/dev/pom.xml

WORKDIR /opt/dev/pp-backend/

#Criando o jar do projeto
RUN mvn package

WORKDIR /opt/dev/pp-backend/target

#Iniciando o projeto
ENTRYPOINT ["java", "-jar", "pp-backend-1.0.0.jar"]