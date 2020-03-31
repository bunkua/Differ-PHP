redump:
	composer dump-autoload

install:
	composer install

lint:
	composer run-script phpcs -- --standard=PSR12 src bin

test:
	composer run-script phpunit tests/

plain:
	bin/gendiff tests/fixtures/json/before.json tests/fixtures/json/after.json

nested:
	bin/gendiff tests/fixtures/json/before2.json tests/fixtures/json/after2.json

plain-yml:
	bin/gendiff tests/fixtures/yaml/before.yaml tests/fixtures/yaml/after.yml

nested-yml:
	bin/gendiff tests/fixtures/yaml/before2.yaml tests/fixtures/yaml/after2.yml
