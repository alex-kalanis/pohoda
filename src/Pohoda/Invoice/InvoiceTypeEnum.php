<?php

namespace kalanis\Pohoda\Invoice;

use kalanis\Pohoda\Common;

/**
 * Enum for available invoice types
 */
enum InvoiceTypeEnum: string implements Common\Enums\EnhancedEnumInterface
{
    use Common\Enums\EnumTrait;

    case IssuedInvoice = 'issuedInvoice';
    case IssuedCreditNotice = 'issuedCreditNotice';
    case IssuedDebitNote = 'issuedDebitNote';
    case IssuedAdvanceInvoice = 'issuedAdvanceInvoice';
    case Receivable = 'receivable';
    case IssuedProformaInvoice = 'issuedProformaInvoice';
    case Penalty = 'penalty';
    case IssuedCorrectiveTax = 'issuedCorrectiveTax';
    case ReceivedInvoice = 'receivedInvoice';
    case ReceivedCreditNotice = 'receivedCreditNotice';
    case ReceivedDebitNote = 'receivedDebitNote';
    case ReceivedAdvanceInvoice = 'receivedAdvanceInvoice';
    case Commitment = 'commitment';
    case ReceivedProformaInvoice = 'receivedProformaInvoice';
    case ReceivedCorrectiveTax = 'receivedCorrectiveTax';
}
