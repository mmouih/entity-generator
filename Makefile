all: cs review test
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf src
check:
	./vendor/bin/phpcs src
	./vendor/bin/phpstan
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