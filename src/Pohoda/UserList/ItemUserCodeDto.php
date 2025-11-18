<?php

namespace kalanis\Pohoda\UserList;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;

class ItemUserCodeDto extends AbstractItemDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $code = null;
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $constant = null;
}
