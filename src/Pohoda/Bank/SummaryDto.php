<?php

namespace kalanis\Pohoda\Bank;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractSummaryDto;
use kalanis\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    #[Attributes\Options\ListOption(['none'])]
    public ?string $roundingDocument = null;
    #[Attributes\Options\ListOption(['none'])]
    public ?string $roundingVAT = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
