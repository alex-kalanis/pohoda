<?php

namespace kalanis\Pohoda\PrintRequest;

use AllowDynamicProperties;
use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

#[AllowDynamicProperties]
class ParametersDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public ?int $copy = null;
    #[Attributes\Options\StringOption]
    public ?string $datePrint = null;
}
