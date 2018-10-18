FROM mongo:3.2

RUN get https://s3.amazonaws.com/careers-picpay/users.csv.gz
RUN tar -czf users.csv.gz

ADD users.csv \
  /tmp/

CMD until echo 'db.stats().ok' | mongo mongo/picdb --quiet; \
    do sleep 1; \
  done && \
  mongo picdb \
  --host mongo \
  --eval "db.dropDatabase();" && \
  # NOTE: keep the above lines
  mongoimport \
  --host mongo \
  --db picdb \
  --collection users \
  --type csv \
  --jsonArray \
  --file /tmp/users.csv; \
  # NOTE: keep the following line
  sleep 8640