app.build:
	docker compose build php_app

app.sh:
	make up && docker compose exec -it php_app sh

app.phpunit:
	docker compose run --entrypoint="composer" php_app run phpunit

app.fixtures:
	docker compose run --entrypoint="bin/console" php_app doctrine:fixtures:load -n

app.db.recreate:
	docker compose run --entrypoint="composer" php_app db:recreate:dev

app.migrate:
	docker compose run --entrypoint="bin/console" php_app doctrine:migrations:migrate -n

app.setupe2e:
	make app.migrate && make app.fixtures

app.install:
	docker compose run --entrypoint="composer" php_app install

nginx.build:
	docker compose build webserver

install:
	make app.install

up:
	docker compose up -d

down:
	docker compose down

ps:
	docker compose ps

build:
	make app.build && make nginx.build
