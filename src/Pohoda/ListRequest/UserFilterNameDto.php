<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class UserFilterNameDto extends AbstractDto
{
    #[Attributes\Options\StringOption(200), Attributes\Options\RequiredOption]
    public ?string $userFilterName = null;

    public static function init(string $name): self
    {
        $dto = new self();
        $dto->userFilterName = $name;
        return $dto;
    }
}
