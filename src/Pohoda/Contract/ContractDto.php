<?php

namespace kalanis\Pohoda\Contract;

use kalanis\Pohoda\Common\Dtos;

class ContractDto extends Dtos\AbstractDto
{
    public Desc|DescDto|null $header = null;
}
