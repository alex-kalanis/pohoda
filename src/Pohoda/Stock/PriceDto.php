<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Dtos;

class PriceDto extends Dtos\AbstractDto
{
    public ?string $id = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    public array|string|null $ids = null;
    public ?float $price = null;
}
