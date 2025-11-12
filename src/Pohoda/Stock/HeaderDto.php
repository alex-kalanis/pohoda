<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    // basic data
    public ?string $stockType = null;
    public ?string $code = null;
    public ?string $EAN = null;
    public ?string $PLU = null;
    public bool|string|null $isSales = null;
    public bool|string|null $isSerialNumber = null;
    public bool|string|null $isInternet = null;
    public bool|string|null $isBatch = null;
    public ?string $purchasingRateVAT = null;
    public ?string $purchasingRatePayVAT = null;
    public ?string $sellingRateVAT = null;
    public ?string $sellingRatePayVAT = null;
    public ?string $name = null;
    public ?string $nameComplement = null;
    public ?string $unit = null;
    public ?string $unit2 = null;
    public ?string $unit3 = null;
    public float|string|null $coefficient2 = null;
    public float|string|null $coefficient3 = null;
    #[Attributes\RefElement]
    public array|string|null $storage = null;
    #[Attributes\RefElement]
    public array|string|null $typePrice = null;
    public float|string|null $purchasingPrice = null;
    public bool|string|null $purchasingPricePayVAT = null;
    public float|string|null $sellingPrice = null;
    public bool|string|null $sellingPricePayVAT = null;
    public float|string|null $limitMin = null;
    public float|string|null $limitMax = null;
    public float|string|null $mass = null;
    public float|string|null $volume = null;
    #[Attributes\RefElement]
    public array|string|null $supplier = null;
    public ?string $orderName = null;
    public float|string|null $orderQuantity = null;
    public ?string $shortName = null;
    #[Attributes\RefElement]
    public ?string $typeRP = null;
    public ?string $guaranteeType = null;
    public int|string|null $guarantee = null;
    public ?string $producer = null;
    #[Attributes\RefElement]
    public ?string $typeServiceMOSS = null;
    public ?string $description = null;
    public ?string $description2 = null;
    public ?string $note = null;
    public Intrastat|IntrastatDto|null $intrastat = null;
    public RecyclingContrib|RecyclingContribDto|null $recyclingContrib = null;

    // data for response
    #[Attributes\ResponseDirection]
    public ?string $id = null;
    #[Attributes\ResponseDirection]
    public float|string|null $weightedPurchasePrice = null;
    #[Attributes\ResponseDirection]
    public float|string|null $count = null;
    #[Attributes\ResponseDirection]
    public float|string|null $countIssue = null;
    #[Attributes\ResponseDirection]
    public float|string|null $countReceivedOrders = null;
    #[Attributes\ResponseDirection]
    public float|string|null $reservation = null;
    #[Attributes\ResponseDirection]
    public float|string|null $countIssuedOrders = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $clearanceSale = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $controlLimitTaxLiability = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $discount = null;
    #[Attributes\ResponseDirection]
    public ?string $fixation = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $markRecord = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $news = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $prepare = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $recommended = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $sale = null;
    #[Attributes\ResponseDirection]
    public ?string $reclamation = null;
    #[Attributes\ResponseDirection]
    public ?string $service = null;

    // contains extra elements
    /** @var \ArrayAccess<Category|CategoryDto>|array<Category|CategoryDto> */
    public \ArrayAccess|array $categories = [];
    /** @var \ArrayAccess<Picture|PictureDto>|array<Picture|PictureDto> */
    public \ArrayAccess|array $pictures = [];
    /** @var \ArrayAccess<Type\Parameter|Type\Dtos\ParameterDto>|array<Type\Parameter|Type\Dtos\ParameterDto> */
    public \ArrayAccess|array $parameters = [];
    /** @var \ArrayAccess<IntParameter|IntParameterDto>|array<IntParameter|IntParameterDto> */
    public \ArrayAccess|array $intParameters = [];
}
