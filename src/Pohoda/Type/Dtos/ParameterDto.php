<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

/**
 * Basic DTO for parameters
 */
class ParameterDto extends AbstractDto
{
    public ?string $name = null;
    public ?string $type = null;
    public mixed $value = null;
    public mixed $list = null;
}
