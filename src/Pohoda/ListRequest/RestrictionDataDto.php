<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class RestrictionDataDto extends AbstractDto
{
    #[Attributes\Options\BooleanOption]
    public bool|string|null $liquidations = null;
}
