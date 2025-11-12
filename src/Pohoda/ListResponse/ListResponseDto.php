<?php

namespace Riesenia\Pohoda\ListResponse;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\ListRequest;
use Riesenia\Pohoda\Order;
use Riesenia\Pohoda\Stock;

#[AllowDynamicProperties]
class ListResponseDto extends AbstractDto
{
    public ?string $type = null;
    public ?string $state = null;
    public ?string $namespace = null;
    public ?string $orderType = null;
    public ?string $invoiceType = null;
    #[Attributes\JustAttribute]
    public ListRequest\Limit|ListRequest\LimitDto|null $limit = null;
    #[Attributes\JustAttribute]
    public ListRequest\Filter|ListRequest\FilterDto|null $filter = null;
    #[Attributes\JustAttribute]
    public ListRequest\RestrictionData|ListRequest\RestrictionDataDto|null $restrictionData = null;
    #[Attributes\JustAttribute]
    public ListRequest\UserFilterName|ListRequest\UserFilterNameDto|null $userFilterName = null;
    /** @var \ArrayAccess<Order>|array<Order> */
    public \ArrayAccess|array $order = [];
    /** @var \ArrayAccess<Stock>|array<Stock> */
    public \ArrayAccess|array $stock = [];
    public \DateTimeInterface|string|null $timestamp = null;
    public \DateTimeInterface|string|null $validFrom = null;
}
