<?php

namespace common\models;

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
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const WORKS_MODE_WEEKDAYS = 'weekdays';  // будни
    public const WORKS_MODE_DAILY = 'daily';        // ежедневно

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
            [['status'], 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['works_mode'], 'in', 'range' => [self::WORKS_MODE_WEEKDAYS, self::WORKS_MODE_DAILY]],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['works_mode'], 'default', 'value' => self::WORKS_MODE_WEEKDAYS],
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
     */
    public static function getStatusList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Активен',
            self::STATUS_INACTIVE => 'Неактивен',
        ];
    }

    /**
     * Получить список режимов работы [en => ru]
     *
     * @return array
     */
    public static function getWorksModeList(): array
    {
        return [
            self::WORKS_MODE_WEEKDAYS => 'Только будни',
            self::WORKS_MODE_DAILY => 'Ежедневно',
        ];
    }

    /**
     * Получить ru статус
     *
     * @return string
     */
    public function getRuStatus(): string
    {
        return self::getStatusList()[$this->status] ?? $this->status;
    }

    /**
     * Получить ru режим работы
     *
     * @return string
     */
    public function getRuWorksMode(): string
    {
        return self::getWorksModeList()[$this->works_mode] ?? $this->works_mode;
    }
}
