<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class RecyclingContribDto extends Dtos\AbstractDto
{
    public ?string $recyclingContribType = null;
    public ?string $coefficientOfRecyclingContrib = null;
}
