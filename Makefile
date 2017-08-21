easy_install:
	docker-compose up

full_install:
	docker-compose -f docker-compose-populated.yml up

full_install_run:

down:
	docker-compose -f docker-compose.yml down
	docker-compose -f docker-compose-populated.yml down
