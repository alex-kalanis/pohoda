<?php

namespace kalanis\Pohoda\CashSlip;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractSummaryDto;
use kalanis\Pohoda\Common\Enums;
use kalanis\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    #[Attributes\Options\EnumOption(Enums\RoundingDocumentEnum::class)]
    public Enums\RoundingDocumentEnum|string|null $roundingDocument = null;
    #[Attributes\Options\EnumOption(Enums\RoundingVatEnum::class)]
    public Enums\RoundingVatEnum|string|null $roundingVAT = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $calculateVAT = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    #[Attributes\OnlyInternal]
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
