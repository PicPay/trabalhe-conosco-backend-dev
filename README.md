# PicUser App
An app to list Pic Pay's users.

## Installation Requirements
- **JDK 8** or superior
- **Docker**: I used version 18.03.1-ce (2018-04-26)

## Approach

I developed the APP on a JVM based language called **Kotlin**. 
I served the App using **Spring Boot** and **Spring Data** frameworks via **Gradle**.

I stored all the data to an **Elasticsearch** database that enables full-text searching on users.
The 8 million users and their priorities were imported to Elasticsearch using **Logstash**. 
This process usually takes over an hour to complete. 
User's priority list were transformed as simple numeric values from 0 to 2. 
A user with priority 2 means he/she was at the list of priority 1 and thus should appear first.
I used **Docker** to set up both Elasticsearch and Logstash across multi platforms.

I took advantage of Spring's static resources to build a front end in **React** and **Redux** quicker then if I were to setup another server.
I used **Material Design** on components whenever I could: **React Material UI**.
Finally, I choose a simpler form of **authentication via Google** with a validation from the back checking if the user's email is registered as a system administrator.

## Register a new admin
Go to `/data/admin.`
```

```

1 - Start the elastic search database:
```shell
sudo docker-compose up elasticsearch
```

2 - Build and run the app executing at the terminal:
```shell
./gradlew clean build
./gradlew bootRun
```

3 - Access it at `localhost:8080`

## Import 8 million users to the database

Copy the file `users.csv` and paste it to the `/data` folder and execute the following command, please remember this task may take over an hour to complete.

```shell
sudo docker-compose up import-users
```

After the task is finished, setup the users priorities by running (this should take less than a minute):
```shell
sudo docker-compose up set-priorities
```

If the importation is done you can now kill the respective logstash container just typing: 
```shell
sudo docker-compose kill import-users
sudo docker-compose kill set-priorities
```

If something is already running on port 9200 and you can't start those containers, find the process running at that port and kill the process:
```shell
sudo lsof -i :9200 | grep LISTEN
sudo kill <PID>
```

## How to make requests to the server?

Send a `POST` to `http://localhost:8080/user/search` with a JSON payload:

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