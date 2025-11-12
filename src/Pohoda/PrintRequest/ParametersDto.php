<?php

namespace Riesenia\Pohoda\PrintRequest;

use AllowDynamicProperties;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

#[AllowDynamicProperties]
class ParametersDto extends AbstractDto
{
    public ?int $copy = null;
    public ?string $datePrint = null;
}
