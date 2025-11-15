<?php

namespace Riesenia\Pohoda\Common\Dtos;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

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
