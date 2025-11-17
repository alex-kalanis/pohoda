<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class SupplierItemDto extends AbstractItemDto
{
    #[Attributes\Options\BooleanOption]
    public bool|string|null $default = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $refAd = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $orderCode = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $orderName = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $purchasingPrice = null;
    #[Attributes\RefElement]
    public ?string $currency = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $rate = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $payVAT = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $ean = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $printEAN = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unitEAN = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $unitCoefEAN = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $deliveryTime = null;
    #[Attributes\RefElement]
    public ?string $deliveryPeriod = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $minQuantity = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit = null;
    public ?string $note = null;
}
