<?php

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractSummaryDto;
use Riesenia\Pohoda\Type;

class SummaryDto extends AbstractSummaryDto
{
    #[Attributes\Options\ListOption(['none', 'math2one', 'math2half', 'math2tenth', 'math5cent', 'up2one', 'up2half', 'up2tenth', 'down2one', 'down2half', 'down2tenth'])]
    public ?string $roundingDocument = null;
    #[Attributes\Options\ListOption(['none', 'noneEveryRate', 'up2tenthEveryItem', 'up2tenthEveryRate', 'math2tenthEveryItem', 'math2tenthEveryRate', 'math2halfEveryItem', 'math2halfEveryRate', 'math2intEveryItem', 'math2intEveryRate'])]
    public ?string $roundingVAT = null;
    public Type\Dtos\CurrencyHomeDto|Type\CurrencyHome|null $homeCurrency = null;
    public Type\Dtos\CurrencyForeignDto|Type\CurrencyForeign|null $foreignCurrency = null;
}
