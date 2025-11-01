<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class ActionTypeDto extends AbstractDto
{
    public ?string $type = null;
    public \ArrayAccess|array|null $filter = null;
    public ?string $agenda = null;
}
