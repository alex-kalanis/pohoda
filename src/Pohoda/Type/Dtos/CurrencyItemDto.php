<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyItemDto extends AbstractDto
{
    public float|string|null $unitPrice = null;
    public float|string|null $price = null;
    public float|string|null $priceVAT = null;
    public float|string|null $priceSum = null;
}
