<?php

namespace Riesenia\Pohoda\IssueSlip;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    public \DateTimeInterface|string|null $date = null;
    public ?string $numberOrder = null;
    public \DateTimeInterface|string|null $dateOrder = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public ?string $acc = null;
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    public bool|string|null $isExecuted = null;
    public bool|string|null $isDelivered = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\RefElement]
    public ?string $carrier = null;
    #[Attributes\RefElement]
    public ?string $regVATinEU = null;
    #[Attributes\RefElement]
    public ?string $MOSS = null;
    #[Attributes\RefElement]
    public ?string $evidentiaryResourcesMOSS = null;
    public ?string $accountingPeriodMOSS = null;
    public ?string $note = null;
    public ?string $intNote = null;
    public bool|string|null $histRate = null;
    public \ArrayAccess|array $parameters = [];
}
