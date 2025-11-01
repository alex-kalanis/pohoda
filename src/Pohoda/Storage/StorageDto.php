<?php

namespace Riesenia\Pohoda\Storage;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Storage;

class StorageDto extends AbstractItemDto
{
    public string|null $code = null;
    public string|null $name = null;
    /** @var \ArrayAccess<Storage|self>|array<Storage|self> */
    public \ArrayAccess|array $subStorages = [];
}
