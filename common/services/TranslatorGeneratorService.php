<?php

namespace common\services;

use common\models\Enums\TranslatorStatus;
use common\models\Enums\TranslatorWorksMode;
use common\repositories\TranslatorRepository;
use yii\db\Exception;

/**
 * Сервис для генерации тестовых переводчиков
 */
class TranslatorGeneratorService
{
    /** @var TranslatorRepository */
    private TranslatorRepository $repository;

    /**
     * @param TranslatorRepository $repository
     */
    public function __construct(TranslatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Сгенерировать случайных переводчиков
     *
     * @param int $count количество переводчиков
     * @return int количество созданных записей
     * @throws Exception
     */
    public function generate(int $count): int
    {
        $this->repository->truncate();

        // Подготовить данные для вставки
        $data = [];
        $now = date('Y-m-d H:i:s');

        for ($i = 0; $i < $count; $i++) {
            $name = $this->getRandomName();
            $lastName = $this->getRandomLastName();
            $email = $this->generateEmail($i);

            $data[] = [
                $name,
                $lastName,
                $this->getRandomStatus(),
                $email,
                $this->getRandomPrice(),
                $this->getRandomWorksMode(),
                $now,
                $now,
            ];
        }

        return $this->repository->batchInsert($data);
    }

    /**
     * Получить случайное имя
     *
     * @return string
     */
    private function getRandomName(): string
    {
        $names = [
            'Алла',
            'Белла',
            'Максим',
            'Сергей',
            'Роман'
        ];
        return $names[array_rand($names)];
    }

    /**
     * Получить случайную фамилию
     *
     * @return string
     */
    private function getRandomLastName(): string
    {
        $lastNames = [
            'Иванов',
            'Петров',
            'Сидоров',
            'Смирнов',
            'Кузнецов',
        ];
        return $lastNames[array_rand($lastNames)];
    }

    /**
     * Получить случайный статус
     *
     * @return string
     */
    private function getRandomStatus(): string
    {
        $statuses = [TranslatorStatus::ACTIVE->value, TranslatorStatus::INACTIVE->value];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Получить случайный режим работы
     *
     * @return string
     */
    private function getRandomWorksMode(): string
    {
        $modes = [TranslatorWorksMode::WEEKDAYS->value, TranslatorWorksMode::DAILY->value];
        return $modes[array_rand($modes)];
    }

    /**
     * Сгенерировать уникальный email
     *
     * @param int $index
     * @return string
     */
    private function generateEmail(int $index): string
    {
        $randomStr1 = \Yii::$app->security->generateRandomString(6);
        $randomStr2 = \Yii::$app->security->generateRandomString(6);
        
        return strtolower("{$randomStr1}_{$randomStr2}_{$index}@example.com");
    }

    /**
     * Получить случайную цену
     *
     * @return int
     */
    private function getRandomPrice(): int
    {
        return random_int(100, 5000);
    }
}
