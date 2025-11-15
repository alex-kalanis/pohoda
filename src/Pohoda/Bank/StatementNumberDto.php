<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Dtos;

class StatementNumberDto extends Dtos\AbstractDto
{
    public ?string $statementNumber = null;
    public ?string $numberMovement = null;
}
