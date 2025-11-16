<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class PriceDto extends Dtos\AbstractDto
{
    public ?string $id = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    public array|string|null $ids = null;
    public ?float $price = null;
}
