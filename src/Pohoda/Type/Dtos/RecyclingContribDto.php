<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class RecyclingContribDto extends AbstractDto
{
    public ?string $recyclingContribText = null;
    public ?float $recyclingContribAmount = null;
    public ?string $recyclingContribUnit = null;
    public ?float $coefficientOfRecyclingContrib = null;
}
