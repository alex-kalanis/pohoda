<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class IntParameterDto extends Dtos\AbstractDto
{
    #[Attributes\Options\IntegerOption, Attributes\Options\RequiredOption]
    public int|string|null $intParameterID = null;
    public ?string $intParameterName = null;
    public ?string $intParameterOrder = null;
    #[Attributes\Options\ListOption(['textValue', 'currencyValue', 'booleanValue', 'numberValue', 'integerValue', 'datetimeValue', 'unit', 'listValue']), Attributes\Options\RequiredOption]
    public ?string $intParameterType = null;
    #[Attributes\Options\RequiredOption]
    public ?string $value = null;
}
