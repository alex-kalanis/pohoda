<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;
use kalanis\Pohoda\Type;

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
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    public ?string $typeServiceMOSS = null;
    public ?string $note = null;
    public ?string $code = null;
    public ?string $symPar = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    public ?string $accounting = null;
    public ?string $classificationVAT = null;
    public ?string $classificationKVDPH = null;
    public ?string $PDP = null;
    public ?string $CodePDP = null;
    public ?string $recyclingContrib = null;
    #[Attributes\RefElement, Attributes\OnlyInternal]
    public ?string $cashAccount = null;
    #[Attributes\RefElement, Attributes\OnlyInternal]
    public ?string $number = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $EETItem = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
