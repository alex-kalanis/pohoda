<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class RecyclingContribDto extends Dtos\AbstractDto
{
    #[Attributes\RefElement]
    public ?string $recyclingContribType = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficientOfRecyclingContrib = null;
}
