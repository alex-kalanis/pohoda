<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    // basic data
    public ?string $stockType = null;
    public ?string $code = null;
    public ?string $EAN = null;
    public ?string $PLU = null;
    public ?string $isSales = null;
    public ?string $isSerialNumber = null;
    public ?string $isInternet = null;
    public ?string $isBatch = null;
    public ?string $purchasingRateVAT = null;
    public ?string $purchasingRatePayVAT = null;
    public ?string $sellingRateVAT = null;
    public ?string $sellingRatePayVAT = null;
    public ?string $name = null;
    public ?string $nameComplement = null;
    public ?string $unit = null;
    public ?string $unit2 = null;
    public ?string $unit3 = null;
    public ?string $coefficient2 = null;
    public ?string $coefficient3 = null;
    public ?string $storage = null;
    public array|string|null $typePrice = null;
    public ?string $purchasingPrice = null;
    public ?string $purchasingPricePayVAT = null;
    public ?string $sellingPrice = null;
    public ?string $sellingPricePayVAT = null;
    public ?string $limitMin = null;
    public ?string $limitMax = null;
    public ?string $mass = null;
    public ?string $volume = null;
    public ?string $supplier = null;
    public ?string $orderName = null;
    public ?string $orderQuantity = null;
    public ?string $shortName = null;
    public ?string $typeRP = null;
    public ?string $guaranteeType = null;
    public ?string $guarantee = null;
    public ?string $producer = null;
    public ?string $typeServiceMOSS = null;
    public ?string $description = null;
    public ?string $description2 = null;
    public ?string $note = null;
    public Intrastat|IntrastatDto|null $intrastat = null;
    public RecyclingContrib|RecyclingContribDto|null $recyclingContrib = null;

    // data for response
    public ?string $id = null;
    public ?string $weightedPurchasePrice = null;
    public ?string $count = null;
    public ?string $countIssue = null;
    public ?string $countReceivedOrders = null;
    public ?string $reservation = null;
    public ?string $countIssuedOrders = null;
    public ?string $clearanceSale = null;
    public ?string $controlLimitTaxLiability = null;
    public ?string $discount = null;
    public ?string $fixation = null;
    public ?string $markRecord = null;
    public ?string $news = null;
    public ?string $prepare = null;
    public ?string $recommended = null;
    public ?string $sale = null;
    public ?string $reclamation = null;
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
