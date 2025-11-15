<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyForeignDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $currency = null;
    public float|string|null $rate = null;
    public int|string|null $amount = null;
    public float|string|null $priceSum = null;
}
