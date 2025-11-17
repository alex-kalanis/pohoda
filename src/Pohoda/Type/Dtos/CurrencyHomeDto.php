<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CurrencyHomeDto extends AbstractDto
{
    #[Attributes\Options\FloatOption]
    public float|string|null $priceNone = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $price3 = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $price3VAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $price3Sum = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceLow = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceLowVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceLowVatRate = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceLowSum = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceHigh = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceHighVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceHighVatRate = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceHighSum = null;
    /** @var array<string, string|float>|string|null */
    #[Attributes\RefElement]
    public array|string|null $round = null;
}
