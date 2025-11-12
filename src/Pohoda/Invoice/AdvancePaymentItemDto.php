<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;

class AdvancePaymentItemDto extends AbstractDto
{
    #[Attributes\RefElement]
    public array|string|null $sourceDocument = null;
    public float|string|null $quantity = null;
    public string|bool|null $payVAT = null;
    public ?string $rateVAT = null;
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
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
    public \ArrayAccess|array $parameters = [];
}
