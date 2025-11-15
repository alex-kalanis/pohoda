<?php

namespace Riesenia\Pohoda\Storage;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Storage;

class StorageDto extends AbstractItemDto
{
    public ?string $code = null;
    public ?string $name = null;
    /** @var array<Storage|self> */
    #[Attributes\JustAttribute]
    public array $subStorages = [];
}
