<?php

namespace common\models;

use common\models\Enums\TranslatorStatus;
use common\models\Enums\TranslatorWorksMode;
use yii\db\ActiveRecord;

/**
 * Модель переводчика
 *
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string $status
 * @property string|null $email
 * @property int $price
 * @property string $works_mode
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Translator extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%translator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'works_mode'], 'required'],
            [['price'], 'integer'],
            [['name', 'last_name', 'email', 'status', 'works_mode'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['status'], 'in', 'range' => array_keys(TranslatorStatus::labels())],
            [['works_mode'], 'in', 'range' => array_keys(TranslatorWorksMode::labels())],
            [['status'], 'default', 'value' => TranslatorStatus::ACTIVE->value],
            [['works_mode'], 'default', 'value' => TranslatorWorksMode::WEEKDAYS->value],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'status' => 'Статус',
            'email' => 'Email',
            'price' => 'Цена за час',
            'works_mode' => 'Режим работы',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Получить список статусов [en => ru]
     *
     * @return array
     * @deprecated Используйте TranslatorStatus::labels()
     */
    public static function getStatusList(): array
    {
        return TranslatorStatus::labels();
    }

    /**
     * Получить список режимов работы [en => ru]
     *
     * @return array
     * @deprecated Используйте TranslatorWorksMode::labels()
     */
    public static function getWorksModeList(): array
    {
        return TranslatorWorksMode::labels();
    }

    /**
     * Получить ru статус
     *
     * @return string
     */
    public function getRuStatus(): string
    {
        return TranslatorStatus::from($this->status)->label() ?? $this->status;
    }

    /**
     * Получить ru режим работы
     *
     * @return string
     */
    public function getRuWorksMode(): string
    {
        return TranslatorWorksMode::from($this->works_mode)->label() ?? $this->works_mode;
    }
}
