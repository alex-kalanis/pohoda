<?php

namespace Riesenia\Pohoda\UserList;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class ItemUserCodeDto extends AbstractItemDto
{
    public ?string $code = null;
    public ?string $name = null;
    public ?string $constant = null;
}
