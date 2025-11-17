<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class CategoryDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption, Attributes\Options\RequiredOption]
    public ?int $idCategory = null;
}
