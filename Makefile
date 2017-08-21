easy_install:
	docker-compose up

full_install:
	docker-compose -f docker-compose-populated.yml up

docker_run:
	docker run -d --name app_mongodb mateusvtt/mongo_populated
	docker run -d --name app_web -p 3000:80 --link app_mongodb mateusvtt/nodejs-ready

down:
	docker-compose -f docker-compose.yml down
	docker-compose -f docker-compose-populated.yml down
