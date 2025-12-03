<?php

namespace kalanis\Pohoda\IntParam;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Common\Enums;

class IntParamDto extends Dtos\AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $name = null;
    public ?string $description = null;
    #[Attributes\Options\EnumOption(Enums\ParamTypeEnum::class), Attributes\Options\RequiredOption]
    public Enums\ParamTypeEnum|string|null $parameterType = null;
    public Settings|SettingsDto|null $parameterSettings = null;
}
