<?php

namespace kalanis\Pohoda\Common\Enums;

/**
 * Enum for available types of parameters
 */
enum ParamTypeEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case TextValue = 'textValue';
    case CurrencyValue = 'currencyValue';
    case BooleanValue = 'booleanValue';
    case NumberValue = 'numberValue';
    case IntegerValue = 'integerValue';
    case DatetimeValue = 'datetimeValue';
    case Unit = 'unit';
    case ListValue = 'listValue';

}
