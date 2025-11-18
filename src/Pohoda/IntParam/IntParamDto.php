<?php

namespace kalanis\Pohoda\IntParam;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class IntParamDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    public ?string $description = null;
    #[Attributes\Options\ListOption(['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']), Attributes\Options\RequiredOption]
    public ?string $parameterType = null;
    public Settings|SettingsDto|null $parameterSettings = null;
}
