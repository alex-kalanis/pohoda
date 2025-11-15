<?php

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public ?string $offerType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $validTill = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\RefElement]
    public ?string $regVATinEU = null;
    #[Attributes\RefElement]
    public ?string $MOSS = null;
    #[Attributes\RefElement]
    public ?string $evidentiaryResourcesMOSS = null;
    public ?string $accountingPeriodMOSS = null;
    public ?string $isExecuted = null;
    public ?string $details = null;
    public ?string $note = null;
    public ?string $intNote = null;
    public ?string $markRecord = null;
    public \ArrayAccess|array $parameters = [];
}
