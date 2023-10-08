CONTAINER_NAME = findLandRoute-app

start:
	docker-compose build --no-cache
	cd src && composer install
	
stop:
	docker stop $(CONTAINER_NAME) 
	docker stop $(CONTAINER_NAME)-nginx

up:
	docker-compose up --force-recreate

console: 
	docker exec -it $(CONTAINER_NAME) bash

down:
	docker-compose down
