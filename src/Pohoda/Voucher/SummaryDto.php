<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Dtos\AbstractSummaryDto;
use Riesenia\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    public ?string $roundingDocument = null;
    public ?string $roundingVAT = null;
    public ?string $calculateVAT = null;
    public ?string $typeCalculateVATInclusivePrice = null;
    public Type\Dtos\CurrencyHomeDto|AbstractAgenda|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|AbstractAgenda|null $foreignCurrency = null;
}
