<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyItemDto extends AbstractDto
{
    public ?string $unitPrice = null;
    public ?string $price = null;
    public ?string $priceVAT = null;
    public ?string $priceSum = null;
}
