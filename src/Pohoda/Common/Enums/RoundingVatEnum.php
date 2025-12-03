<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for Rounding VAT
 */
enum RoundingVatEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = 'none';
    case NoneEveryRate = 'noneEveryRate';
    case Up2tenthEveryItem = 'up2tenthEveryItem';
    case Up2tenthEveryRate = 'up2tenthEveryRate';
    case Math2tenthEveryItem = 'math2tenthEveryItem';
    case Math2tenthEveryRate = 'math2tenthEveryRate';
    case Math2halfEveryItem = 'math2halfEveryItem';
    case Math2halfEveryRate = 'math2halfEveryRate';
    case Math2intEveryItem = 'math2intEveryItem';
    case Math2intEveryRate = 'math2intEveryRate';

}
