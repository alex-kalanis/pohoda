<?php

namespace Riesenia\Pohoda\ListRequest;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Symfony\Component\OptionsResolver\Options;

#[AllowDynamicProperties]
class ListRequestDto extends AbstractDto
{
    #[Attributes\Options\ListRequestTypeOption, Attributes\Options\RequiredOption]
    public ?string $type = null;
    #[Attributes\Options\DefaultOption(['\Riesenia\Pohoda\ListRequest\ListRequestDto', 'normalizeNamespace'])]
    public ?string $namespace = null;
    #[Attributes\Options\DefaultOption(['\Riesenia\Pohoda\ListRequest\ListRequestDto', 'normalizeOrderType']), Attributes\Options\ListOption([null, 'receivedOrder', 'issuedOrder'])]
    public ?string $orderType = null;
    #[Attributes\Options\DefaultOption(['\Riesenia\Pohoda\ListRequest\ListRequestDto', 'normalizeInvoiceType']), Attributes\Options\ListOption([null, 'issuedInvoice', 'issuedCreditNotice', 'issuedDebitNote', 'issuedAdvanceInvoice', 'receivable', 'issuedProformaInvoice', 'penalty', 'issuedCorrectiveTax', 'receivedInvoice', 'receivedCreditNotice', 'receivedDebitNote', 'receivedAdvanceInvoice', 'commitment', 'receivedProformaInvoice', 'receivedCorrectiveTax'])]
    public ?string $invoiceType = null;
    #[Attributes\JustAttribute]
    public Limit|LimitDto|null $limit = null;
    #[Attributes\JustAttribute]
    public Filter|FilterDto|null $filter = null;
    #[Attributes\JustAttribute]
    public QueryFilter|QueryFilterDto|null $queryFilter = null;
    #[Attributes\JustAttribute]
    public RestrictionData|RestrictionDataDto|null $restrictionData = null;
    #[Attributes\JustAttribute]
    public UserFilterName|UserFilterNameDto|null $userFilterName = null;

    public static function normalizeNamespace(Options $options): string
    {
        if ('Stock' == $options['type']) {
            return 'lStk';
        }

        if ('AddressBook' == $options['type']) {
            return 'lAdb';
        }
        /*
        if ('AccountingUnit' == $options['type']) {
            return 'acu';
        }
        if ('Contract' == $options['type']) {
            return 'lCon';
        }
        if ('Centre' == $options['type']) {
            return 'lCen';
        }

        if ('Activity' == $options['type']) {
            return 'lAcv';
        }
        */
        return 'lst';
    }

    public static function normalizeOrderType(Options $options): ?string
    {
        if ('Order' == $options['type']) {
            return 'receivedOrder';
        }

        return null;
    }

    public static function normalizeInvoiceType(Options $options): ?string
    {
        if ('Invoice' == $options['type']) {
            return 'issuedInvoice';
        }

        return null;
    }
}
