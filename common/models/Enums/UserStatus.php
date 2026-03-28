<?php

namespace common\models\Enums;

/**
 * Перечисление статусов пользователя
 */
enum UserStatus: int
{
    case DELETED = 0;
    case INACTIVE = 9;
    case ACTIVE = 10;

    /**
     * Получить текстовую метку статуса
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::DELETED => 'Удален',
            self::INACTIVE => 'Неактивен',
            self::ACTIVE => 'Активен',
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
            self::DELETED->value => self::DELETED->label(),
            self::INACTIVE->value => self::INACTIVE->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
        ];
    }
}
