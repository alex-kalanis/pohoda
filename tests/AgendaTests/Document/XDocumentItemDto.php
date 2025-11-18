<?php

namespace tests\AgendaTests\Document;

use kalanis\Pohoda\Common\Dtos\AbstractItemDto;
use kalanis\Pohoda\Type;

class XDocumentItemDto extends AbstractItemDto
{
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
