<?php

namespace Riesenia\Pohoda\Order;

use Riesenia\Pohoda\Document;
use Riesenia\Pohoda\Type;

class OrderDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
}
