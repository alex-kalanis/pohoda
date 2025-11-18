<?php

namespace kalanis\Pohoda\Receipt;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractItemDto;
use kalanis\Pohoda\Type;

class ItemDto extends AbstractItemDto
{
    #[Attributes\Options\FloatOption]
    public float|string|null $quantity = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficient = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $payVAT = null;
    #[Attributes\Options\ListOption(['none', 'third', 'low', 'high'])]
    public ?string $rateVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $discountPercentage = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $homeCurrency = null;
    public Type\Dtos\CurrencyItemDto|Type\CurrencyItem|null $foreignCurrency = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $code = null;
    public Type\Dtos\StockItemDto|Type\StockItem|null $stockItem = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $note = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
