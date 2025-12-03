<?php

namespace kalanis\Pohoda\Common\Enums;

use kalanis\Pohoda\Common\EmptyInterface;

/**
 * Enum for available types of order
 */
enum OrderTypeEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = EmptyInterface::EMPTY_VALUE;
    case ReceivedOrder = 'receivedOrder';
    case IssuedOrder = 'issuedOrder';

}
