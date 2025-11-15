<?php

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    public float|string|null $quantity = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    public ?string $note = null;
}
