#!/bin/bash
php vendor/bin/phpunit --coverage-html /tmp/report
open /tmp/report/index.html
