<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class ActionTypeDto extends AbstractDto
{
    #[Attributes\Options\ListOption(['add', 'add/update', 'update', 'delete']), Attributes\Options\RequiredOption]
    public ?string $type = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>> */
    public array $filter = [];
    public ?string $agenda = null;
}
