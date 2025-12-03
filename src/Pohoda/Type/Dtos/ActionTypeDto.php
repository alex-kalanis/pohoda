<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type\Enums;

class ActionTypeDto extends AbstractDto
{
    #[Attributes\Options\EnumOption(Enums\ActionTypeEnum::class), Attributes\Options\RequiredOption]
    public Enums\ActionTypeEnum|string|null $type = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>> */
    public array $filter = [];
    public ?string $agenda = null;
}
