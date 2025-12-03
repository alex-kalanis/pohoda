<?php

namespace kalanis\Pohoda\Type\Enums;

use kalanis\Pohoda\Common;

/**
 * Enum for available parameter types
 */
enum ParameterTypeEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case Text = 'text';
    case Memo = 'memo';
    case Currency = 'currency';
    case Boolean = 'boolean';
    case Number = 'number';
    case DateTime = 'datetime';
    case Integer = 'integer';
    case List = 'list';
}
