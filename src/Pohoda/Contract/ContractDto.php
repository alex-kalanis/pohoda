<?php

namespace Riesenia\Pohoda\Contract;

use Riesenia\Pohoda\Common\Dtos;

class ContractDto extends Dtos\AbstractDto
{
    public Desc|DescDto|null $header = null;
}
