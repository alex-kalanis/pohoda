<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type\Enums;

class LinkDto extends AbstractDto
{
    #[Attributes\Options\EnumOption(Enums\LinkSourceAgendaEnum::class)]
    public Enums\LinkSourceAgendaEnum|string|null $sourceAgenda = null;
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $sourceDocument = null;
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $settingsSourceDocument = null;
}
