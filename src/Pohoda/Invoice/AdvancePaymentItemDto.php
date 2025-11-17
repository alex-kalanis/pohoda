<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;

class AdvancePaymentItemDto extends AbstractDto
{
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $sourceDocument = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $quantity = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $payVAT = null;
    #[Attributes\Options\ListOption(['none', 'third', 'low', 'high'])]
    public ?string $rateVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $note = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $symPar = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
