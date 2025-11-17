<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class QueryFilterDto extends AbstractDto
{
    #[Attributes\Options\StringOption]
    public ?string $filter = null;
    #[Attributes\Options\StringOption(200)]
    public ?string $textName = null;
}
