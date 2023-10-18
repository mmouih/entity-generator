all: cs analyse
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf
analyse:
	./vendor/bin/phpstan
install:
	composer install
sf_update:
	composer update symfony/*