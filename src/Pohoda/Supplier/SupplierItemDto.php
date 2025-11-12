<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class SupplierItemDto extends AbstractItemDto
{
    public bool|string|null $default = null;
    #[Attributes\RefElement]
    public string|array|null $refAd = null;
    public ?string $orderCode = null;
    public ?string $orderName = null;
    public int|string|null $purchasingPrice = null;
    #[Attributes\RefElement]
    public ?string $currency = null;
    public float|string|null $rate = null;
    public bool|string|null $payVAT = null;
    public ?string $ean = null;
    public bool|string|null $printEAN = null;
    public ?string $unitEAN = null;
    public float|string|null $unitCoefEAN = null;
    public int|string|null $deliveryTime = null;
    #[Attributes\RefElement]
    public ?string $deliveryPeriod = null;
    public float|string|null $minQuantity = null;
    public ?string $unit = null;
    public ?string $note = null;
}
