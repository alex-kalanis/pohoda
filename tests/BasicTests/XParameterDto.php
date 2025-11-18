<?php

namespace tests\BasicTests;

use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type;

class XParameterDto extends AbstractDto
{
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
