<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum trait for work with them
 */
trait EnumTrait
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::names(), self::values());
    }

    public function currentValue(): string
    {
        return $this->value;
    }
}
