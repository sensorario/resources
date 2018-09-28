install:
	php composer.phar install

suite:
	php -d display_errors ./bin/phpunit --stop-on-failure

coverage:
	php ./bin/phpunit --coverage-html /tmp/coverage/
	open /tmp/coverage/index.html
