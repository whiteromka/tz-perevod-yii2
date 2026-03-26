Для развертывания выполнить след команды в папке с проектом:

docker-compose up -d --build

docker-compose exec backend composer install

// Если будет ругаться на уязвимости в пакетах phpunit/phpunit:
composer config audit.ignore PKSA-z3gr-8qht-p93v

docker-compose exec backend php yii migrate

// Создать тестового пользователя для захода в админку
// с параметрами: username = 'rom', email = 'rom@rom.ru', password = '123'
docker-compose exec backend php yii user/create

// Создать 100 тестового переводчиков
docker-compose exec backend php yii translator/generate

Готово:
Тут фронт на Vue js с формой фильтрации
http://localhost:20080/
Тут админка с простым crud и формой фильтрации на php
http://localhost:21080/

Тесты:
docker-compose exec backend php vendor/bin/codecept run common/tests/unit/services/TranslatorGeneratorServiceTest.php
docker-compose exec backend php vendor/bin/codecept run common/tests/unit/services/UserServiceTest.php