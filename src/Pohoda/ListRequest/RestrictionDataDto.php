<?php

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class RestrictionDataDto extends AbstractDto
{
    #[Attributes\Options\BooleanOption]
    public bool|string|null $liquidations = null;
}
