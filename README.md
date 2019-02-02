# PicUser App
An app to list 8 million of Pic Pay's users.

![screenshot](https://github.com/johnguerson/trabalhe-conosco-backend-dev/blob/master/images/app-page.png)

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

## Register an admin user
Add a new valid email at `application.properties`, all entries should be separated by comma:
```
users.admin=email1@domain.com.br,email2@domain.com
```

## Execute the project
1 - Start the elastic search database in a separate terminal window:
```shell
sudo docker-compose up elasticsearch
```

If something is already running on port 9200 and you can't start this container, find the process running at that port and kill the process:
```shell
sudo lsof -i :9200 | grep LISTEN
sudo kill <PID>
```

2 - Build and run the app at another terminal window as it follows. 
Make sure you start the app BEFORE you import any data to the database since 
Spring Data will create all document mappings and settings for us.
```shell
./gradlew clean build
./gradlew bootRun
```

3 - Access it at `localhost:8080` and see no data is displayed yet.

## Import 8 million users data

Copy the file `users.csv` and paste it to the `/data` folder and execute the following command at a new terminal window, 
please remember this task may take over an hour to complete.

```shell
sudo docker-compose up import-users
```

AFTER the task is finished, setup users priorities by running at another terminal (this should take only few seconds):
```shell
sudo docker-compose up set-priorities
```

When all importation are done, kill logstash containers executing: 
```shell
sudo docker-compose kill import-users
sudo docker-compose kill set-priorities
```
