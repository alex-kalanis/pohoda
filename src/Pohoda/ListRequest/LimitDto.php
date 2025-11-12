<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class LimitDto extends AbstractDto
{
    public int|string|null $idFrom = null;
    public int|string|null $count = null;
}
