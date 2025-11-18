<?php

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class QueryFilterDto extends AbstractDto
{
    #[Attributes\Options\StringOption]
    public ?string $filter = null;
    #[Attributes\Options\StringOption(200)]
    public ?string $textName = null;
}
