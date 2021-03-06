.PHONY: all deps test fixer phpstan deptrac

all: deps test

deps:
	docker-compose run --rm php composer install

test:
	docker-compose run --rm php composer test

fixer:
	docker-compose run --rm php composer cs:fix

phpstan:
	docker-compose run --rm php composer phpstan

deptrac:
	docker-compose run --rm php composer deptrac
