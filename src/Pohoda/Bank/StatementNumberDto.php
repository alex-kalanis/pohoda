<?php

namespace kalanis\Pohoda\Bank;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;

class StatementNumberDto extends Dtos\AbstractDto
{
    #[Attributes\Options\StringOption(10)]
    public ?string $statementNumber = null;
    #[Attributes\Options\StringOption(6)]
    public ?string $numberMovement = null;
}
