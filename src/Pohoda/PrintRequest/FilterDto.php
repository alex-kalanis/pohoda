<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class FilterDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $id = null;
}
