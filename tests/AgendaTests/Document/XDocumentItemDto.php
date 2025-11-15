<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class XDocumentItemDto extends AbstractItemDto
{
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
}
