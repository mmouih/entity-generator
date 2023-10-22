all: cs analyze
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf src
check:
	./vendor/bin/phpcs src
	./vendor/bin/phpstan
analyze:
	./vendor/bin/phpstan
build:
	composer install
sf_update:
	composer update symfony/*
poc:
	./app generate User tests/data/user.json