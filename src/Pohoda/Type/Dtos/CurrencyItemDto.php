<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class CurrencyItemDto extends AbstractDto
{
    #[Attributes\Options\FloatOption]
    public float|string|null $unitPrice = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $price = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceSum = null;
}
