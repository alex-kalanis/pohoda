<?php

namespace kalanis\Pohoda\Type\Enums;

use kalanis\Pohoda\Common;

/**
 * Enum for available action types
 */
enum ActionTypeEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case Add = 'add';
    case AddUpdate = 'add/update';
    case Update = 'update';
    case Delete = 'delete';
}
