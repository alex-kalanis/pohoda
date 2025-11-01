<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class StockItemDto extends AbstractItemDto
{
    public array|string|null $stockItem = null;
}
