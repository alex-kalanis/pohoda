<?php

namespace kalanis\Pohoda\CashSlip;

use kalanis\Pohoda\Common;

/**
 * Enum for available types
 */
enum ProdejkaTypeEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case SaleVoucher = 'saleVoucher';
    case Deposit = 'deposit';
    case Withdrawal = 'withdrawal';
}
