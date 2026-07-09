.PHONY: up down shell composer artisan test npm build

up:
	docker compose up -d

down:
	docker compose down

shell:
	docker compose exec app bash

composer:
	docker compose exec app composer $(cmd)

artisan:
	docker compose exec app php artisan $(cmd)

test:
	docker compose exec app php artisan test $(filter-out $@,$(MAKECMDGOALS))

npm:
	docker compose --profile dev run --rm node sh -c "$(cmd)"

build:
	docker compose --profile dev run --rm node sh -c "npm install && npm run build"

dev:
	docker compose --profile dev up -d

%:
	@:
