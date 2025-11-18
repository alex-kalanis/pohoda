<?php

namespace kalanis\Pohoda\UserList;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;

class UserListDto extends AbstractItemDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $code = null;
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $constants = null;
    #[Attributes\Options\DateTimeOption]
    public \DateTimeInterface|string|null $dateTimeStamp = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateValidFrom = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $submenu = null;
    /** @var array<ItemUserCode> */
    #[Attributes\JustAttribute]
    public array $itemUserCodes = [];
}
