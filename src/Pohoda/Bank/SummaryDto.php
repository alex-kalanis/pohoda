<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractSummaryDto;
use Riesenia\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    #[Attributes\Options\ListOption(['none'])]
    public ?string $roundingDocument = null;
    #[Attributes\Options\ListOption(['none'])]
    public ?string $roundingVAT = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
