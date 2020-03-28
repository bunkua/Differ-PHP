redump:
	composer dump-autoload

install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 src bin

plain:
	bin/gendiff tests/fixtures/before.json tests/fixtures/after.json

nested:
	bin/gendiff tests/fixtures/before2.json tests/fixtures/after2.json
