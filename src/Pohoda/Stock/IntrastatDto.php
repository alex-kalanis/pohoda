<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class IntrastatDto extends Dtos\AbstractDto
{
    #[Attributes\Options\StringOption(8)]
    public ?string $goodsCode = null;
    #[Attributes\Options\StringOption(255)]
    public ?string $description = null;
    #[Attributes\Options\StringOption(2)]
    public ?string $statistic = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficient = null;
    #[Attributes\Options\StringOption(2)]
    public ?string $country = null;
}
