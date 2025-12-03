<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common;

/**
 * Enum for available stock types
 */
enum StockTypeEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case Card = 'card';
    case Text = 'text';
    case Service = 'service';
    case Package = 'package';
    case Set = 'set';
    case Product = 'product';
}
