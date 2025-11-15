<?php

namespace Riesenia\Pohoda\UserList;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class UserListDto extends AbstractItemDto
{
    public ?string $code = null;
    public ?string $name = null;
    public ?string $constants = null;
    public \DateTimeInterface|string|null $dateTimeStamp = null;
    public \DateTimeInterface|string|null $dateValidFrom = null;
    public ?string $submenu = null;
    /** @var array<ItemUserCode> */
    #[Attributes\JustAttribute]
    public array $itemUserCodes = [];
}
