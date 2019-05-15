#!/usr/bin/env bash

vendor/bin/phpstan analyse -c phpstan.neon --autoload-file=./vendor/autoload.php src
vendor/bin/phpstan analyse -c phpstan.relaxed.neon --autoload-file=./vendor/autoload.php tests

vendor/bin/phpunit