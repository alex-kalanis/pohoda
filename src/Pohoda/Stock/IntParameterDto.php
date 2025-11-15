<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class IntParameterDto extends Dtos\AbstractDto
{
    public int|string|null $intParameterID = null;
    public ?string $intParameterName = null;
    public ?string $intParameterOrder = null;
    public ?string $intParameterType = null;
    public ?string $value = null;
}
