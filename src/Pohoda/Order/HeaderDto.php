<?php

namespace Riesenia\Pohoda\Order;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\ResponseDirection]
    public ?int $id = null;
    #[Attributes\RefElement]
    public ?string $extId = null;
    public ?string $orderType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public ?string $numberOrder = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $dateDelivery = null;
    public \DateTimeInterface|string|null $dateFrom = null;
    public \DateTimeInterface|string|null $dateTo = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    public bool|string|null $isExecuted = null;
    public bool|string|null $isReserved = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $isDelivered = null;
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
    public ?string $note = null;
    #[Attributes\RefElement]
    public ?string $carrier = null;
    public ?string $intNote = null;
    public ?string $markRecord = null;
    public ?string $histRate = null;
    #[Attributes\ResponseDirection]
    public bool|string|null $permanentDocument = null;
    public \ArrayAccess|array $parameters = [];
}
