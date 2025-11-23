<?php

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    // basic data
    #[Attributes\Options\ListOption(['card', 'text', 'service', 'package', 'set', 'product']), Attributes\Options\DefaultOption('card')]
    public ?string $stockType = null;
    public ?string $code = null;
    public ?string $EAN = null;
    public ?string $PLU = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isSales = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isSerialNumber = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isInternet = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isBatch = null;
    #[Attributes\Options\ListOption(['none', 'third', 'low', 'high'])]
    public ?string $purchasingRateVAT = null;
    #[Attributes\AttributeExtend('purchasingRateVAT', 'value')]
    public ?string $purchasingRatePayVAT = null;
    #[Attributes\Options\ListOption(['none', 'third', 'low', 'high'])]
    public ?string $sellingRateVAT = null;
    #[Attributes\AttributeExtend('sellingRateVAT', 'value')]
    public ?string $sellingRatePayVAT = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $name = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $nameComplement = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit2 = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $unit3 = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficient2 = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $coefficient3 = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $storage = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $typePrice = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $purchasingPrice = null;
    #[Attributes\Options\BooleanOption, Attributes\AttributeExtend('purchasingPrice', 'payVAT')]
    public bool|string|null $purchasingPricePayVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $sellingPrice = null;
    #[Attributes\Options\BooleanOption, Attributes\AttributeExtend('sellingPrice', 'payVAT')]
    public bool|string|null $sellingPricePayVAT = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $limitMin = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $limitMax = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $mass = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $volume = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $supplier = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $orderName = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $orderQuantity = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $shortName = null;
    #[Attributes\RefElement]
    public ?string $typeRP = null;
    #[Attributes\Options\ListOption(['none', 'hour', 'day', 'month', 'year', 'life'])]
    public ?string $guaranteeType = null;
    #[Attributes\Options\IntegerOption]
    public int|string|null $guarantee = null;
    #[Attributes\Options\StringOption(90)]
    public ?string $producer = null;
    #[Attributes\RefElement]
    public ?string $typeServiceMOSS = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $description = null;
    public ?string $description2 = null;
    public ?string $note = null;
    public Intrastat|IntrastatDto|null $intrastat = null;
    public RecyclingContrib|RecyclingContribDto|null $recyclingContrib = null;

    // data for response
    #[Attributes\ResponseDirection]
    public ?string $id = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $weightedPurchasePrice = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $count = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $countIssue = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $countReceivedOrders = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $reservation = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $countIssuedOrders = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $clearanceSale = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $controlLimitTaxLiability = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $discount = null;
    #[Attributes\ResponseDirection, Attributes\Options\StringOption(90)]
    public ?string $fixation = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $markRecord = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $news = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $prepare = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $recommended = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $sale = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $reclamation = null;
    #[Attributes\ResponseDirection, Attributes\Options\FloatOption]
    public float|string|null $service = null;

    // contains extra elements
    /** @var array<Category|CategoryDto> */
    public array $categories = [];
    /** @var array<Picture|PictureDto> */
    public array $pictures = [];
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
    /** @var array<IntParameter|IntParameterDto> */
    #[Attributes\Options\StringOption()]
    public array $intParameters = [];
}
