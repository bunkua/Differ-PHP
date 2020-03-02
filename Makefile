redump:
	composer dump-autoload

install:
	composer install && make redump

make lint:
	composer run-script phpcs -- --standard=PSR12 src bin