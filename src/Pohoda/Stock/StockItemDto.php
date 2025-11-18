<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class StockItemDto extends Dtos\AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $id = null;
    #[Attributes\RefElement]
    public ?string $stockInfo = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $storage = null;
    public ?string $code = null;
    public ?string $name = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $count = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $quantity = null;
    /** @var array<Price|PriceDto> */
    public array $stockPriceItem = [];
}
