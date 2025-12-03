<?php

namespace kalanis\Pohoda\ListResponse;

use AllowDynamicProperties;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Common\Enums;
use kalanis\Pohoda\ListRequest;
use kalanis\Pohoda\Order;
use kalanis\Pohoda\Stock;
use Symfony\Component\OptionsResolver\Options;

#[AllowDynamicProperties]
class ListResponseDto extends AbstractDto
{
    #[Attributes\Options\ListRequestTypeOption, Attributes\Options\RequiredOption]
    public ?string $type = null;
    public ?string $state = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListResponse\ListResponseDto', 'normalizeNamespace'])]
    public ?string $namespace = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListResponse\ListResponseDto', 'normalizeOrderType']), Attributes\Options\EnumOption(Enums\OrderTypeEnum::class)]
    public Enums\OrderTypeEnum|string|null $orderType = null;
    #[Attributes\Options\DefaultOption(['\kalanis\Pohoda\ListResponse\ListResponseDto', 'normalizeInvoiceType']), Attributes\Options\EnumOption(Enums\InvoiceTypeEnum::class)]
    public Enums\InvoiceTypeEnum|string|null $invoiceType = null;
    #[Attributes\JustAttribute]
    public ListRequest\Limit|ListRequest\LimitDto|null $limit = null;
    #[Attributes\JustAttribute]
    public ListRequest\Filter|ListRequest\FilterDto|null $filter = null;
    #[Attributes\JustAttribute]
    public ListRequest\RestrictionData|ListRequest\RestrictionDataDto|null $restrictionData = null;
    #[Attributes\JustAttribute]
    public ListRequest\UserFilterName|ListRequest\UserFilterNameDto|null $userFilterName = null;
    /** @var array<Order> */
    public array $order = [];
    /** @var array<Stock> */
    public array $stock = [];
    public \DateTimeInterface|string|null $timestamp = null;
    public \DateTimeInterface|string|null $validFrom = null;

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
        */
        if ('Contract' == $options['type']) {
            return 'lCon';
        }
        /*
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
