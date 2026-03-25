up:
	docker compose up -d

cli:
	docker exec -it football_events_app bash

install:
	docker exec -it football_events_app composer install

test:
	docker exec -it football_events_app php vendor/codeception/codeception/app.php run