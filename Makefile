# Global Makefile

### Variables ###

### Rules ###

install:
	composer install --no-dev

develop:
	composer install

update:
	composer update --no-dev

update_dev:
	composer update

test_cov:
	vendor/bin/phpunit --coverage-text

test_cov_html:
	vendor/bin/phpunit --coverage-html=./coverage/

### Travis CI ###

travis_before_install:
	composer self-update
	composer global require hirak/prestissimo

travis_install:
	composer install --prefer-dist --no-interaction

travis_test_cov:
	vendor/bin/phpunit --coverage-clover=coverage.xml

travis_codecov: SHELL:=/bin/bash
travis_codecov:
	bash <(curl -s https://codecov.io/bash)
