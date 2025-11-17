<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;

class StatementNumberDto extends Dtos\AbstractDto
{
    #[Attributes\Options\StringOption(10)]
    public ?string $statementNumber = null;
    #[Attributes\Options\StringOption(6)]
    public ?string $numberMovement = null;
}
