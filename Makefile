.SENSORARIO: suite
suite:
	php -d display_errors ./bin/phpunit --stop-on-failure

.SENSORARIO: coverage
coverage:
	php ./bin/phpunit --coverage-html /tmp/coverage/
	open /tmp/coverage/index.html
