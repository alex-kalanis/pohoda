<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class RestrictionDataDto extends AbstractDto
{
    public bool|string|null $liquidations = null;
}
