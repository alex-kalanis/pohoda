<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyForeignDto extends AbstractDto
{
    public ?string $currency = null;
    public ?string $rate = null;
    public ?string $amount = null;
    public ?string $priceSum = null;
}
