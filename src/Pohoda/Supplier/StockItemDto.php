<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $stockItem = null;
}
