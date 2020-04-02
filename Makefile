redump:
	composer dump-autoload

install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 src bin

test:
	composer run-script phpunit tests/

plain:
	bin/gendiff --format json tests/fixtures/json/before.json tests/fixtures/json/after.json

nested:
	bin/gendiff --format json tests/fixtures/json/before2.json tests/fixtures/json/after2.json
