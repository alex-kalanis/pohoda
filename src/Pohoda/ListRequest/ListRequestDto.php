<?php

namespace kalanis\Pohoda\ListRequest;

use AllowDynamicProperties;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Common\Enums;
use Symfony\Component\OptionsResolver\Options;

#[AllowDynamicProperties]
class ListRequestDto extends AbstractDto
{
    #[Attributes\Options\ListRequestTypeOption, Attributes\Options\RequiredOption]
    public ?string $type = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListRequest\ListRequestDto', 'normalizeNamespace'])]
    public ?string $namespace = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListRequest\ListRequestDto', 'normalizeOrderType']), Attributes\Options\EnumOption(Enums\OrderTypeEnum::class)]
    public Enums\OrderTypeEnum|string|null $orderType = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListRequest\ListRequestDto', 'normalizeInvoiceType']), Attributes\Options\EnumOption(Enums\InvoiceTypeEnum::class)]
    public Enums\InvoiceTypeEnum|string|null $invoiceType = null;
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
