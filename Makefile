all: cs review test
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf src
review:
	./vendor/bin/phpstan
build:
	composer install
test:
	./vendor/bin/phpunit
sf_update:
	composer update symfony/*
poc:
	./app generate User tests/data/user.json