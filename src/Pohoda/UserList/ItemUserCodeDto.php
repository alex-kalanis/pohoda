<?php

namespace Riesenia\Pohoda\UserList;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class ItemUserCodeDto extends AbstractItemDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $code = null;
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $constant = null;
}
