<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class SupplierDto extends AbstractDto
{
    public StockItem|StockItemDto|null $stockItem = null;
    /** @var array<SupplierItem|SupplierItemDto> */
    public array $suppliers = [];
}
