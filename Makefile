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
json-demo:
	./app generate User tests/data/user.json -f
xml-demo:
	./app generate User tests/data/user.xml xml -f