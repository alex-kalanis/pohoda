<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class CurrencyForeignDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $currency = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $rate = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $amount = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $priceSum = null;
}
