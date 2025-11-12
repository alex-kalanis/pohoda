<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    public ?string $text = null;
    public float|string|null $quantity = null;
    public ?string $unit = null;
    public float|string|null $coefficient = null;
    public string|bool|null $payVAT = null;
    public ?string $rateVAT = null;
    public float|string|null $percentVAT = null;
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Attributes\RefElement]
    public ?string $typeServiceMOSS = null;
    public ?string $note = null;
    public ?string $code = null;
    public ?int $guarantee = null;
    public ?string $guaranteeType = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
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
    public \DateTimeInterface|string|null $expirationDate = null;
    public bool|string|null $PDP = null;
    public Type\Dtos\RecyclingContribDto|Type\RecyclingContrib|null $recyclingContrib = null;
}
