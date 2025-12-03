<?php

namespace kalanis\Pohoda\Common\Enums;

use kalanis\Pohoda\Common\EmptyInterface;

/**
 * Enum for available types of invoices
 */
enum InvoiceTypeEnum: string implements EnhancedEnumInterface
{
    use EnumTrait;

    case None = EmptyInterface::EMPTY_VALUE;
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
