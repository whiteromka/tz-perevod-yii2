<?php

namespace common\tests\unit\services;

use Codeception\Test\Unit;
use common\services\TranslatorGeneratorService;
use common\repositories\TranslatorRepository;
use common\models\Translator;
use Yii;

/**
 * Тесты для сервиса генерации переводчиков
 */
class TranslatorGeneratorServiceTest extends Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @var TranslatorRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $repositoryMock;

    /**
     * @var TranslatorGeneratorService
     */
    private $service;

    protected function _before()
    {
        // Создаём мок репозитория
        $this->repositoryMock = $this->createMock(TranslatorRepository::class);
        $this->service = new TranslatorGeneratorService($this->repositoryMock);
    }

    /**
     * Тест: генерация указанного количества переводчиков
     *
     * @return void
     */
    public function testGenerateReturnsCorrectCount(): void
    {
        $count = 10;

        // Ожидаем, что truncate будет вызван один раз
        $this->repositoryMock
            ->expects($this->once())
            ->method('truncate');

        // Ожидаем, что batchInsert будет вызван один раз с массивом из $count элементов
        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) use ($count) {
                return is_array($data) && count($data) === $count;
            }))
            ->willReturn($count);

        $result = $this->service->generate($count);

        $this->assertEquals($count, $result);
    }

    /**
     * Тест: генерация одного переводчика
     *
     * @return void
     */
    public function testGenerateSingleTranslator(): void
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) {
                return is_array($data) && count($data) === 1;
            }))
            ->willReturn(1);

        $result = $this->service->generate(1);

        $this->assertEquals(1, $result);
    }

    /**
     * Тест: генерация нуля переводчиков
     *
     * @return void
     */
    public function testGenerateZeroTranslators(): void
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) {
                return is_array($data) && count($data) === 0;
            }))
            ->willReturn(0);

        $result = $this->service->generate(0);

        $this->assertEquals(0, $result);
    }

    /**
     * Тест: структура данных для вставки
     *
     * @return void
     */
    public function testGenerateDataStructure(): void
    {
        $count = 5;

        $this->repositoryMock
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) {
                // Проверяем структуру каждой записи
                foreach ($data as $row) {
                    // Должно быть 8 колонок: name, last_name, status, email, price, works_mode, created_at, updated_at
                    if (!is_array($row) || count($row) !== 8) {
                        return false;
                    }

                    // name - строка
                    if (!is_string($row[0]) || empty($row[0])) {
                        return false;
                    }

                    // last_name - строка
                    if (!is_string($row[1]) || empty($row[1])) {
                        return false;
                    }

                    // status - один из констант Translator
                    if (!in_array($row[2], [Translator::STATUS_ACTIVE, Translator::STATUS_INACTIVE])) {
                        return false;
                    }

                    // email - строка с доменом example.com
                    if (!is_string($row[3]) || !str_ends_with($row[3], '@example.com')) {
                        return false;
                    }

                    // price - число от 100 до 5000
                    if (!is_int($row[4]) || $row[4] < 100 || $row[4] > 5000) {
                        return false;
                    }

                    // works_mode - один из констант Translator
                    if (!in_array($row[5], [Translator::WORKS_MODE_WEEKDAYS, Translator::WORKS_MODE_DAILY])) {
                        return false;
                    }

                    // created_at и updated_at - строки даты
                    if (!is_string($row[6]) || !is_string($row[7])) {
                        return false;
                    }
                }
                return true;
            }))
            ->willReturn($count);

        $this->service->generate($count);
    }

    /**
     * Тест: email содержит индекс
     *
     * @return void
     */
    public function testGenerateEmailContainsIndex(): void
    {
        $count = 3;

        $this->repositoryMock
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) use ($count) {
                // Проверяем, что каждый email содержит свой индекс
                for ($i = 0; $i < $count; $i++) {
                    if (!str_contains($data[$i][3], "_{$i}@example.com")) {
                        return false;
                    }
                }
                return true;
            }))
            ->willReturn($count);

        $this->service->generate($count);
    }

    /**
     * Тест: имена выбираются из предопределённого списка
     *
     * @return void
     */
    public function testGenerateNamesFromList(): void
    {
        $validNames = ['Алла', 'Белла', 'Максим', 'Сергей', 'Роман'];

        $this->repositoryMock
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) use ($validNames) {
                foreach ($data as $row) {
                    if (!in_array($row[0], $validNames)) {
                        return false;
                    }
                }
                return true;
            }))
            ->willReturn(5);

        $this->service->generate(5);
    }

    /**
     * Тест: фамилии выбираются из предопределённого списка
     *
     * @return void
     */
    public function testGenerateLastNamesFromList(): void
    {
        $validLastNames = ['Иванов', 'Петров', 'Сидоров', 'Смирнов', 'Кузнецов'];

        $this->repositoryMock
            ->method('truncate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('batchInsert')
            ->with($this->callback(function ($data) use ($validLastNames) {
                foreach ($data as $row) {
                    if (!in_array($row[1], $validLastNames)) {
                        return false;
                    }
                }
                return true;
            }))
            ->willReturn(5);

        $this->service->generate(5);
    }
}
