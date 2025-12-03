<?php

namespace kalanis\Pohoda\Type\Enums;

use kalanis\Pohoda\Common;

/**
 * Enum for available parameter types
 */
enum LinkSourceAgendaEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case IssuedInvoice = 'issuedInvoice';
    case ReceivedInvoice = 'receivedInvoice';
    case Receivable = 'receivable';
    case Commitment = 'commitment';
    case IssuedAdvanceInvoice = 'issuedAdvanceInvoice';
    case ReceivedAdvanceInvoice = 'receivedAdvanceInvoice';
    case Offer = 'offer';
    case Enquiry = 'enquiry';
    case ReceivedOrder = 'receivedOrder';
    case IssuedOrder = 'issuedOrder';
}
