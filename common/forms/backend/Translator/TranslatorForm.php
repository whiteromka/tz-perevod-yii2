<?php

namespace common\forms\backend\Translator;

use common\models\Enums\TranslatorStatus;
use common\models\Enums\TranslatorWorksMode;
use yii\base\Model;

/**
 * Форма создания/обновления переводчика
 */
class TranslatorForm extends Model
{
    public string $name = '';
    public ?string $last_name = null;
    public string $email = '';
    public int $price = 0;
    public string $status;
    public string $works_mode;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        $this->status = TranslatorStatus::ACTIVE->value;
        $this->works_mode = TranslatorWorksMode::WEEKDAYS->value;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'price'], 'required'],
            [['name', 'last_name', 'email'], 'string', 'max' => 255],
            [['price'], 'integer', 'min' => 0],
            [['email'], 'email'],
            [['status'], 'in', 'range' => array_keys(TranslatorStatus::labels())],
            [['works_mode'], 'in', 'range' => array_keys(TranslatorWorksMode::labels())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'status' => 'Статус',
            'email' => 'Email',
            'price' => 'Цена за час',
            'works_mode' => 'Режим работы',
        ];
    }

    /**
     * Преобразовать в массив атрибутов
     *
     * @return array
     */
    public function attributesToArray(): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'price' => $this->price,
            'status' => $this->status,
            'works_mode' => $this->works_mode,
        ];
    }
}
