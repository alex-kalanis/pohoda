<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for available types of guarantees
 */
enum GuaranteeTypeEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = 'none';
    case Hour = 'hour';
    case Day = 'day';
    case Month = 'month';
    case Year = 'year';
    case Life = 'life';
}
