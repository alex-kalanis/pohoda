<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class StockItemDto extends Dtos\AbstractDto
{
    public ?string $id = null;
    public ?string $stockInfo = null;
    public array|string|null $storage = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $count = null;
    public ?string $quantity = null;
    /** @var \ArrayAccess<Price|PriceDto>|array<Price|PriceDto> */
    public \ArrayAccess|array $stockPriceItem = [];
}
