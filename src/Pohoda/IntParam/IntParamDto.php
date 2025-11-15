<?php

namespace Riesenia\Pohoda\IntParam;

use Riesenia\Pohoda\Common\Dtos;

class IntParamDto extends Dtos\AbstractDto
{
    public ?string $name = null;
    public ?string $description = null;
    public ?string $parameterType = null;
    public Settings|SettingsDto|null $parameterSettings = null;
}
