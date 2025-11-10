<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class IntrastatDto extends Dtos\AbstractDto
{
    public ?string $goodsCode = null;
    public ?string $description = null;
    public ?string $statistic = null;
    public ?string $unit = null;
    public ?string $coefficient = null;
    public ?string $country = null;
}
