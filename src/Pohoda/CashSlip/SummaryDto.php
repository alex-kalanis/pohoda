<?php

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractSummaryDto;
use Riesenia\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    public ?string $roundingDocument = null;
    public ?string $roundingVAT = null;
    public bool|string|null $calculateVAT = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    #[Attributes\OnlyInternal]
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
