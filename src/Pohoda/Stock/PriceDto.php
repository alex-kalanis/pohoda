<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class PriceDto extends Dtos\AbstractDto
{
    public ?string $id = null;
    public ?string $ids = null;
    public float|string|null $price = null;
}
