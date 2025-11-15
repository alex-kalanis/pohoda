<?php

namespace Riesenia\Pohoda\ListRequest;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

#[AllowDynamicProperties]
class ListRequestDto extends AbstractDto
{
    public ?string $type = null;
    public ?string $namespace = null;
    public ?string $orderType = null;
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
}
