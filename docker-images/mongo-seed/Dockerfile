FROM mateusvtt/mongo:3.4.6
RUN apt-get update && apt-get install -y wget
RUN touch /import.lock
COPY ./bin/seed-data.sh /seed-data.sh
COPY ./bin/healthCheck.sh /healthCheck.sh
ENTRYPOINT ["/bin/sh", "-c"]
CMD ["/seed-data.sh"]
