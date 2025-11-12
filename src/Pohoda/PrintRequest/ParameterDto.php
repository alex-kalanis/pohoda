<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class ParameterDto extends AbstractDto
{
    public mixed $value = null;

    public static function init(mixed $value = null): self
    {
        $dto = new self();
        $dto->value = $value;
        return $dto;
    }
}
