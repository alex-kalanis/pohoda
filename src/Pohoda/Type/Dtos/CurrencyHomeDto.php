<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyHomeDto extends AbstractDto
{
    public float|string|null $priceNone = null;
    public float|string|null $price3 = null;
    public float|string|null $price3VAT = null;
    public float|string|null $price3Sum = null;
    public float|string|null $priceLow = null;
    public float|string|null $priceLowVAT = null;
    public float|string|null $priceLowVatRate = null;
    public float|string|null $priceLowSum = null;
    public float|string|null $priceHigh = null;
    public float|string|null $priceHighVAT = null;
    public float|string|null $priceHighVatRate = null;
    public float|string|null $priceHighSum = null;
    /** @var array<string, string|float>|string|null */
    #[Attributes\RefElement]
    public array|string|null $round = null;
}
