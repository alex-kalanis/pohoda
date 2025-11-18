<?php

namespace kalanis\Pohoda\Storage;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;
use kalanis\Pohoda\Storage;

class StorageDto extends AbstractItemDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $code = null;
    public ?string $name = null;
    /** @var array<Storage|self> */
    #[Attributes\JustAttribute]
    public array $subStorages = [];
}
