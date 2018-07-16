FROM clojure
RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app
COPY project.clj /usr/src/app
RUN lein deps
COPY . /usr/src/app
RUN wget https://s3.amazonaws.com/careers-picpay/users.csv.gz -P /usr/src/app/resources
RUN gunzip /usr/src/app/resources/users.csv.gz
RUN mv "$(lein uberjar | sed -n 's/^Created \(.*standalone\.jar\)/\1/p')" app-standalone.jar
ENV PORT 8080
EXPOSE 8080
CMD ["java", "-jar", "app-standalone.jar"]
