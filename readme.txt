для развертывания выполнить след команды в папке с проектом:

docker-compose up -d --build

docker-compose exec backend composer install

если будет ругаться на уязвимости в пакетах phpunit/phpunit:
composer config audit.ignore PKSA-z3gr-8qht-p93v

docker-compose exec backend php yii migrate