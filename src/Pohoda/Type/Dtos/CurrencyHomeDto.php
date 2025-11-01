<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyHomeDto extends AbstractDto
{
    public ?string $priceNone = null;
    public ?string $price3 = null;
    public ?string $price3VAT = null;
    public ?string $price3Sum = null;
    public ?string $priceLow = null;
    public ?string $priceLowVAT = null;
    public ?string $priceLowVatRate = null;
    public ?string $priceLowSum = null;
    public ?string $priceHigh = null;
    public ?string $priceHighVAT = null;
    public ?string $priceHighVatRate = null;
    public ?string $priceHighSum = null;
    public ?string $round = null;
}
