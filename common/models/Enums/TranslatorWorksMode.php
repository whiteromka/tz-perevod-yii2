<?php

namespace common\models\Enums;

/**
 * Перечисление режимов работы переводчика
 */
enum TranslatorWorksMode: string
{
    case WEEKDAYS = 'weekdays';
    case DAILY = 'daily';

    /**
     * Получить текстовую метку режима работы
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::WEEKDAYS => 'Только будни',
            self::DAILY => 'Ежедневно',
        };
    }

    /**
     * Получить список всех режимов работы с метками
     *
     * @return array
     */
    public static function labels(): array
    {
        return [
            self::WEEKDAYS->value => self::WEEKDAYS->label(),
            self::DAILY->value => self::DAILY->label(),
        ];
    }
}
