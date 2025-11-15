<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class StockItemDto extends Dtos\AbstractDto
{
    public int|string|null $id = null;
    public ?string $stockInfo = null;
    public array|string|null $storage = null;
    public ?string $code = null;
    public ?string $name = null;
    public float|string|null $count = null;
    public float|string|null $quantity = null;
    /** @var \ArrayAccess<Price|PriceDto>|array<Price|PriceDto> */
    public \ArrayAccess|array $stockPriceItem = [];
}
