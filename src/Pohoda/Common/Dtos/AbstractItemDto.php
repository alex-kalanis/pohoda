<?php

namespace Riesenia\Pohoda\Common\Dtos;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

/**
 * Basic DTO for items
 */
abstract class AbstractItemDto extends AbstractDto
{
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    #[Common\Attributes\OnlyInternal]
    public array $parameters = [];
}
