![PicPay](https://user-images.githubusercontent.com/1765696/26998603-711fcf30-4d5c-11e7-9281-0d9eb20337ad.png)

# Instructions

**Requirements:** docker, docker-compose, JDK 8, Maven.

1. Download the source code to your local box. Linux is recommended. 
2. Build the application with maven: `mvn install` (in the same directory of `pom.xml`).
3. Copy the generated file (`api-1.0.jar`) to `docker/build/`
4. Run `build.sh`. A new Docker image will be created.
5. Go to directory `docker/` and run `docker-compose up -d`
6. Two containers will be started: one for MySQL and the other for this application (*note: it is assumed the DB will be populated through some external process.* DDL script can be found at `sql/schema.sql`).
7. Once all containers are ready, the API may be accessed through the base URL `http://<IP>:8080/v1/api/users`:
```bash
curl http://localhost:8080/vi/api/users/abc
```
