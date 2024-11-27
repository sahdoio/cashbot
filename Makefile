# Variables
DC=docker compose --file docker-compose.yml --env-file ./src/.env

.PHONY: up down sh logs setup test migrate

up:
	$(DC) up -d --build
	$(DC) exec vcore composer install

setup: up

down:
	$(DC) down

sh:
	$(DC) exec vcore bash

test:
	$(DC) exec vcore vendor/bin/pest --coverage

test-report:
	$(DC) exec vcore vendor/bin/pest --coverage-html=report

logs:
	$(DC) logs -f --tail=10

migrate:
	$(DC) exec vcore php artisan migrate

npm:
	$(DC) exec vcore-node npm install

vite:
	$(DC) exec vcore-node npm run dev
