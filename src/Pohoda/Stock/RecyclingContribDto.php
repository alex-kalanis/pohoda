<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class RecyclingContribDto extends Dtos\AbstractDto
{
    #[Attributes\RefElement]
    public ?string $recyclingContribType = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficientOfRecyclingContrib = null;
}
