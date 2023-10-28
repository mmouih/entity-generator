all: validate cs review test
cs:
	./vendor/bin/phpcs src
fix:
	./vendor/bin/phpcbf src
review:
	./vendor/bin/phpstan
build:
	composer install
validate:
	composer validate
test:
	./vendor/bin/phpunit
sf_update:
	composer update symfony/*
json:
	./app generate User tests/data/user.json -f
xml:
	./app generate User tests/data/user.xml xml -f
yaml:
	./app generate User tests/data/user.yaml yaml -f