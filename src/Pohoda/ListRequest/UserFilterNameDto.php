<?php

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

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
