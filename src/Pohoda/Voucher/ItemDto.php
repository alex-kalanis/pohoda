<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    public ?string $text = null;
    public ?string $quantity = null;
    public ?string $unit = null;
    public ?string $coefficient = null;
    public ?string $payVAT = null;
    public ?string $rateVAT = null;
    public ?string $percentVAT = null;
    public ?string $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|AbstractAgenda|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|AbstractAgenda|null $foreignCurrency = null;
    public ?string $typeServiceMOSS = null;
    public ?string $note = null;
    public ?string $code = null;
    public ?string $symPar = null;
    public Type\Dtos\StockItemDto|AbstractAgenda|null $stockItem = null;
    public ?string $accounting = null;
    public ?string $classificationVAT = null;
    public ?string $classificationKVDPH = null;
    public ?string $PDP = null;
    public ?string $CodePDP = null;
    public ?string $recyclingContrib = null;
    public ?string $centre = null;
    public ?string $activity = null;
    public ?string $contract = null;
    public ?string $EETItem = null;
    public \ArrayAccess|array $parameters = [];
}
