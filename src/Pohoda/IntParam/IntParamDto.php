<?php

namespace Riesenia\Pohoda\IntParam;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class IntParamDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    public ?string $description = null;
    #[Attributes\Options\ListOption(['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']), Attributes\Options\RequiredOption]
    public ?string $parameterType = null;
    public Settings|SettingsDto|null $parameterSettings = null;
}
