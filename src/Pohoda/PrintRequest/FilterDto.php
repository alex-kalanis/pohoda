<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class FilterDto extends AbstractDto
{
    public int|string|null $id = null;
}
