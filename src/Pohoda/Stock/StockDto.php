<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Type;

class StockDto extends Dtos\AbstractDto
{
    public Type\ActionType|Type\Dtos\ActionTypeDto|null $actionType = null;
    public Header|HeaderDto|null $header = null;
    /** @var array<StockItem|StockItemDto> */
    public array $stockDetail = [];
    /** @var array<Price|PriceDto> */
    public array $stockPriceItem = [];
}
