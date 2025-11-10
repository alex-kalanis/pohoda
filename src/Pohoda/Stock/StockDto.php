<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class StockDto extends Dtos\AbstractDto
{
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<StockItem|StockItemDto>|array<StockItem|StockItemDto> */
    public \ArrayAccess|array $stockDetail = [];
    /** @var \ArrayAccess<Price|PriceDto>|array<Price|PriceDto> */
    public \ArrayAccess|array $stockPriceItem = [];
}
