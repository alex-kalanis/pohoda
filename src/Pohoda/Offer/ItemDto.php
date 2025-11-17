<?php

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;
use Riesenia\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    #[Attributes\Options\StringOption(90)]
    public ?string $text = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $quantity = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficient = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $payVAT = null;
    #[Attributes\Options\ListOption(['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird'])]
    public ?string $rateVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $percentVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Attributes\RefElement]
    public ?string $typeServiceMOSS = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $note = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $code = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $PDP = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
