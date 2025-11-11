<?php

namespace Riesenia\Pohoda\Order;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class OrderDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $details = [];
    public Summary|SummaryDto|null $summary = null;
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
}
