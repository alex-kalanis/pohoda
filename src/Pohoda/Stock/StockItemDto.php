<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class StockItemDto extends Dtos\AbstractDto
{
    public int|string|null $id = null;
    #[Attributes\RefElement]
    public ?string $stockInfo = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $storage = null;
    public ?string $code = null;
    public ?string $name = null;
    public float|string|null $count = null;
    public float|string|null $quantity = null;
    /** @var array<Price|PriceDto> */
    public array $stockPriceItem = [];
}
