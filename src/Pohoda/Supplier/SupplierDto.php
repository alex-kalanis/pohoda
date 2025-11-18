<?php

namespace kalanis\Pohoda\Supplier;

use kalanis\Pohoda\Common\Dtos\AbstractDto;

class SupplierDto extends AbstractDto
{
    public StockItem|StockItemDto|null $stockItem = null;
    /** @var array<SupplierItem|SupplierItemDto> */
    public array $suppliers = [];
}
