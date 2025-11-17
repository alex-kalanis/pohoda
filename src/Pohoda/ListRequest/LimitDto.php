<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class LimitDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $idFrom = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $count = null;
}
