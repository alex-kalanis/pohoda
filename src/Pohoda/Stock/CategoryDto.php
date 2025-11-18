<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class CategoryDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption, Attributes\Options\RequiredOption]
    public ?int $idCategory = null;
}
