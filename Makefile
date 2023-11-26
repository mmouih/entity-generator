all: validate cs review test
cs:
	./vendor/bin/phpcs src
	./vendor/bin/phpcs rector.php
	./vendor/bin/phpcs ecs.php
fix:
	./vendor/bin/phpcbf src
	./vendor/bin/phpcbf rector.php
	./vendor/bin/phpcbf ecs.php
review:
	./vendor/bin/phpstan
build:
	composer install
validate:
	composer validate
refactor:
	./vendor/bin/rector process
	./vendor/bin/ecs check src --fix
refactor-soft:
	./vendor/bin/rector process src --dry-run
test:
	./vendor/bin/phpunit
sf_update:
	composer update symfony/*
json:
	./phpgen generate User tests/data/user.json -f
xml:
	./phpgen generate User tests/data/user.xml xml -f
yaml:
	./phpgen generate User tests/data/user.yaml yaml -f