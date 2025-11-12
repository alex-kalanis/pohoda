<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class QueryFilterDto extends AbstractDto
{
    public ?string $filter = null;
    public ?string $textName = null;
}
