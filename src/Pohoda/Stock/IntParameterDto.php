<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Common\Enums;

class IntParameterDto extends Dtos\AbstractDto
{
    #[Attributes\Options\IntegerOption, Attributes\Options\RequiredOption]
    public int|string|null $intParameterID = null;
    public ?string $intParameterName = null;
    public ?string $intParameterOrder = null;
    #[Attributes\Options\EnumOption(Enums\ParamTypeEnum::class), Attributes\Options\RequiredOption]
    public Enums\ParamTypeEnum|string|null $intParameterType = null;
    #[Attributes\Options\RequiredOption]
    public ?string $value = null;
}
