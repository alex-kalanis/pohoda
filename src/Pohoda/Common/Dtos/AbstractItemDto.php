<?php

namespace kalanis\Pohoda\Common\Dtos;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type;

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
