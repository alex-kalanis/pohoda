<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    #[Attributes\RefElement]
    public array|string|null $stockItem = null;
}
