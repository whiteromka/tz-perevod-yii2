<?php

namespace common\repositories;

use common\models\Translator;
use yii\db\Exception;
use yii\db\ActiveQuery;
use yii\data\ActiveDataProvider;

/**
 * Репозиторий для работы с переводчиками в БД
 */
class TranslatorRepository
{
    /**
     * Очистить таблицу переводчиков (truncate)
     *
     * @return void
     * @throws Exception
     */
    public function truncate(): void
    {
        Translator::deleteAll();
        Translator::getDb()->createCommand()->resetSequence(Translator::tableName(), 1)->execute();
    }

    /**
     * Пакетная вставка переводчиков
     *
     * @param array $data массив данных для вставки
     * @return int количество вставленных записей
     * @throws Exception
     */
    public function batchInsert(array $data): int
    {
        $columns = ['name', 'last_name', 'status', 'email', 'price', 'works_mode', 'created_at', 'updated_at'];
        
        Translator::getDb()->createCommand()->batchInsert(
            Translator::tableName(),
            $columns,
            $data
        )->execute();

        return count($data);
    }

    /**
     * Получить переводчика по ID
     *
     * @param int $id
     * @return Translator|null
     */
    public function getById(int $id): ?Translator
    {
        return Translator::findOne($id);
    }

    /**
     * Получить переводчика по email
     *
     * @param string $email
     * @return Translator|null
     */
    public function getByEmail(string $email): ?Translator
    {
        return Translator::findOne(['email' => $email]);
    }

    /**
     * Получить всех активных переводчиков
     *
     * @return Translator[]
     */
    public function getAllActive(): array
    {
        return Translator::find()
            ->where(['status' => Translator::STATUS_ACTIVE])
            ->all();
    }

    /**
     * Получить базовый запрос для выборки переводчиков
     *
     * @return ActiveQuery
     */
    public function getQuery(): ActiveQuery
    {
        return Translator::find();
    }
}
