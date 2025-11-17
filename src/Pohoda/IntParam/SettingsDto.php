<?php

namespace Riesenia\Pohoda\IntParam;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class SettingsDto extends AbstractItemDto
{
    public ?string $unit = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $length = null;
    #[Attributes\RefElement]
    public ?string $currency = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    public array|string|null $parameterList = null;
}
