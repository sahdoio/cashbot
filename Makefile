# Variables
DC=docker compose --file docker-compose.yml --env-file ./src/.env

.PHONY: up down sh logs setup test migrate

up:
	$(DC) up -d --build
	$(DC) exec cashbot composer install

setup: up

down:
	$(DC) down

sh:
	$(DC) exec cashbot bash

test:
	$(DC) exec cashbot vendor/bin/pest --coverage

test-report:
	$(DC) exec cashbot vendor/bin/pest --coverage-html=report

logs:
	$(DC) logs -f --tail=10

migrate:
	$(DC) exec cashbot php artisan migrate

npm:
	$(DC) exec cashbot-node npm install

vite:
	$(DC) exec cashbot-node npm run dev
