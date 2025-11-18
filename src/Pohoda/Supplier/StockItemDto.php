<?php

namespace kalanis\Pohoda\Supplier;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $stockItem = null;
}
