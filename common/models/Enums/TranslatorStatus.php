<?php

namespace common\models\Enums;

/**
 * Перечисление статусов переводчика
 */
enum TranslatorStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    /**
     * Получить текстовую метку статуса
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Активен',
            self::INACTIVE => 'Неактивен',
        };
    }

    /**
     * Получить список всех статусов с метками
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::ACTIVE->value => self::ACTIVE->label(),
            self::INACTIVE->value => self::INACTIVE->label(),
        ];
    }
}
