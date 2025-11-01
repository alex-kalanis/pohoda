<?php

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class SupplierItemDto extends AbstractItemDto
{
    public ?string $default = null;
    public string|array|null $refAd = null;
    public ?string $orderCode = null;
    public ?string $orderName = null;
    public ?string $purchasingPrice = null;
    public ?string $currency = null;
    public ?string $rate = null;
    public ?string $payVAT = null;
    public ?string $ean = null;
    public ?string $printEAN = null;
    public ?string $unitEAN = null;
    public ?string $unitCoefEAN = null;
    public ?string $deliveryTime = null;
    public ?string $deliveryPeriod = null;
    public ?string $minQuantity = null;
    public ?string $unit = null;
    public ?string $note = null;
}
