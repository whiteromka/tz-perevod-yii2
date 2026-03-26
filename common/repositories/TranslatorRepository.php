<?php

namespace common\repositories;

use common\models\Translator;
use yii\db\Exception;

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
}
