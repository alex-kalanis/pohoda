<?php

namespace kalanis\Pohoda\Common\Dtos;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type;

/**
 * Basic DTO for summaries
 */
abstract class AbstractSummaryDto extends AbstractDto
{
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    #[Common\Attributes\OnlyInternal]
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
