<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class UserFilterNameDto extends AbstractDto
{
    public ?string $userFilterName = null;

    public static function init(string $name): self
    {
        $dto = new self();
        $dto->userFilterName = $name;
        return $dto;
    }
}
