<?php

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class LimitDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $idFrom = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $count = null;
}
