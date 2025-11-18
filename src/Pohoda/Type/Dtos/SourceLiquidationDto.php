<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class SourceLiquidationDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public ?int $sourceItemId = null;
}
