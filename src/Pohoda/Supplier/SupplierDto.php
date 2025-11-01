<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class SupplierDto extends AbstractItemDto
{
    public StockItem|StockItemDto|null $stockItem = null;
    /** @var \ArrayAccess<SupplierItem|SupplierItemDto>|array<SupplierItem|SupplierItemDto> */
    public \ArrayAccess|array $suppliers = [];
}
