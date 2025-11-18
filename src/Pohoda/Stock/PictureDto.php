<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class PictureDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $filepath = null;
    public ?string $description = null;
    #[Attributes\Options\IntegerOption]
    public ?int $order = null;
    #[Attributes\JustAttribute, Attributes\Options\BooleanOption, Attributes\Options\DefaultOption(false)]
    public bool|string|null $default = null;
}
