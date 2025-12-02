<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for Rate VAT
 */
enum RateVatEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = 'none';
    case Third = 'third';
    case Low = 'low';
    case High = 'high';
}
