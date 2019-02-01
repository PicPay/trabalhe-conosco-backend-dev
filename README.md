# PicUser App
An app to manage Pic Pay's users.

## Technologies I used

- I used a JVM based language called **Kotlin** in its most recent version.

- I served the App using **Spring Boot** and **Spring Data** frameworks via **Gradle**.

- I stored data to an **Elasticsearch** database enabling the full-text search feature.

- All 8 million users and their priorities were imported to the Elasticsearch database using **Logstash**. Last time I ran this process it took over an hour for it to complete (of course some improvements may be done here). User's priorities were transformed to the database as simple numeric values from 0 to 2. The value 2 means that users were at the list of priority 1 and should appear first.

- I used **Docker** to set up both Elasticsearch and Logstash across multi platforms.

- I took advantage of Spring's static resources to build a front end in **React** and **Redux** quicker then if I were to setup another server. I used **Material Design** on components whenever I could: **React Material UI**.

- I choose a simpler form of **authentication via Google** with a validation from the back matching user names.

## How to run

1 - Start the elastic search database:
```shell
sudo docker-compose up elasticsearch
```

2 - Build and run the app by executing at the terminal:
```shell
./gradlew clean build
./gradlew bootRun
```

3 - Access it at `localhost:8080`

## How to import 8 million users to the database?

Copy the file `users.csv` and paste it to the `/data` folder and execute the following command, but please remember this task may take over an hour to complete.

```shell
sudo docker-compose up import-users
```

After the task is finished, setup the users priorities by running (this should take less than a minute):
```shell
sudo docker-compose up set-priorities
```

If you need to stop a logstash container to end it abruptly, type: 
```shell
sudo docker-compose kill import-users
```

And if something is already running on port 9200 and you can't start those containers, find the process running at that port and kill the process:
```shell
sudo lsof -i :9200 | grep LISTEN
sudo kill <PID>
```

## How to make requests to the server?

Send a `POST` to `http://localhost:8080/user/search` with a similar JSON payload:

```js
{
   "text": "Silva",
   "page": 0,
   "size": 15
}
```

To see all available users, send a `POST` to `http://localhost:8080/user/all` with this JSON payload:
    
```js
{
   "page": 0,
   "size": 15
}
``` 

