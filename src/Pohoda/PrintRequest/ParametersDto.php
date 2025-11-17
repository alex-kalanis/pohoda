<?php

namespace Riesenia\Pohoda\PrintRequest;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

#[AllowDynamicProperties]
class ParametersDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public ?int $copy = null;
    #[Attributes\Options\StringOption]
    public ?string $datePrint = null;
}
