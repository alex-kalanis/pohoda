<?php

namespace kalanis\Pohoda\StockTransfer;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;
use kalanis\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    #[Attributes\Options\FloatOption]
    public float|string|null $quantity = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $note = null;
}
