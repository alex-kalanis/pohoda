<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class RecyclingContribDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $recyclingContribType = null;
    public ?string $recyclingContribText = null;
    public float|string|null $recyclingContribAmount = null;
    public ?string $recyclingContribUnit = null;
    public float|string|null $coefficientOfRecyclingContrib = null;
}
