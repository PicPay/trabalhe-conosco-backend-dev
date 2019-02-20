FROM openjdk:11-jre-slim

COPY infra/start.sh /opt/start.sh
RUN chmod +x /opt/start.sh
COPY target/trabalhe*.jar /opt/app.jar
EXPOSE 8080
CMD /opt/start.sh