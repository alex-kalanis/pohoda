<?php

namespace kalanis\Pohoda\Order;

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
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
    #[Attributes\ResponseDirection, Attributes\Options\StringOption]
    public ?string $typeCalculateVATInclusivePrice = null;
}
