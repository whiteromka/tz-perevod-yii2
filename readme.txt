Для развертывания выполнить след команды в папке с проектом:

docker-compose up -d --build

docker-compose exec backend composer install

php init

// Если будет ругаться на уязвимости в пакетах phpunit/phpunit:
composer config audit.ignore PKSA-z3gr-8qht-p93v

// Подключение к БД
'db' => [
    'class' => \yii\db\Connection::class,
    'dsn' => 'mysql:host=mysql;dbname=yii2advanced',
    'username' => 'yii2advanced',
    'password' => 'secret',
    'charset' => 'utf8',
],

docker-compose exec backend php yii migrate

// Создать тестового пользователя для захода в админку
// с параметрами: username = 'rom', email = 'rom@rom.ru', password = '123'
docker-compose exec backend php yii user-generate/create rom rom@rom.ru 123

// Создать 100 тестовых переводчиков
docker-compose exec backend php yii translator-generate/create 100

Готово:
Тут фронт на Vue js с формой фильтрации
http://localhost:20080/
Тут админка с простым crud и формой фильтрации на php
http://localhost:21080/

Тесты:
docker-compose exec backend php vendor/bin/codecept run common/tests/unit/services/TranslatorGeneratorServiceTest.php