all: cs analyse
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf src
check:
	./vendor/bin/phpcs src
	./vendor/bin/phpstan
analyse:
	./vendor/bin/phpstan
install:
	composer install
sf_update:
	composer update symfony/*

poc:
	./app generate User tests/data/user.json