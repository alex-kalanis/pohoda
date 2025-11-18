<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Common\Dtos\AbstractSummaryDto;
use kalanis\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    public ?string $roundingDocument = null;
    public ?string $roundingVAT = null;
    public ?string $calculateVAT = null;
    public ?string $typeCalculateVATInclusivePrice = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
