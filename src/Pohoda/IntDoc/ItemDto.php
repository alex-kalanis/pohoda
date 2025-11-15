<?php

namespace Riesenia\Pohoda\IntDoc;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    public ?string $text = null;
    public float|string|null $quantity = null;
    public ?string $unit = null;
    public float|string|null $coefficient = null;
    public bool|string|null $payVAT = null;
    public ?string $rateVAT = null;
    public float|string|null $percentVAT = null;
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Attributes\RefElement]
    public ?string $typeServiceMOSS = null;
    public ?string $note = null;
    public ?string $code = null;
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    public bool|string|null $PDP = null;
    public ?string $CodePDP = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
}
