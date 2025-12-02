<?php

namespace kalanis\Pohoda\Common\Enums;

use UnitEnum;

/**
 * Enum interface for enhance work with them
 */
interface EnhancedEnumInterface extends UnitEnum
{
    /**
     * @return string[]
     */
    public static function names(): array;

    /**
     * @return string[]|int[]
     */
    public static function values(): array;

    /**
     * @return array<string, string|int>
     */
    public static function array(): array;

    public function currentValue(): string;
}
