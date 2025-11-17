<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

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
