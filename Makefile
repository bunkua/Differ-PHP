redump:
	composer dump-autoload

install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 src bin tests

test:
	composer run-script phpunit -- --no-coverage tests/

test-coverage:
	composer run-script phpunit tests/