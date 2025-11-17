<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class SourceLiquidationDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public ?int $sourceItemId = null;
}
