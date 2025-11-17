<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class RecyclingContribDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $recyclingContribType = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $recyclingContribText = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $recyclingContribAmount = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $recyclingContribUnit = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficientOfRecyclingContrib = null;
}
