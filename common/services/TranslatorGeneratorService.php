<?php

namespace common\services;

use common\repositories\TranslatorRepository;
use common\models\Translator;
use Yii;

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
     * @throws \yii\db\Exception
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
        $statuses = [Translator::STATUS_ACTIVE, Translator::STATUS_INACTIVE];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Получить случайный режим работы
     *
     * @return string
     */
    private function getRandomWorksMode(): string
    {
        $modes = [Translator::WORKS_MODE_WEEKDAYS, Translator::WORKS_MODE_DAILY];
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
        $randomStr1 = Yii::$app->security->generateRandomString(6);
        $randomStr2 = Yii::$app->security->generateRandomString(6);
        
        return strtolower("{$randomStr1}_{$randomStr2}_{$index}@example.com");
    }

    /**
     * Получить случайную цену
     *
     * @return int
     * @throws RandomException
     */
    private function getRandomPrice(): int
    {
        return random_int(100, 5000);
    }
}
