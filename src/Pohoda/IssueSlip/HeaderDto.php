<?php

namespace Riesenia\Pohoda\IssueSlip;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $numberOrder = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateOrder = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\Options\StringOption(9)]
    public ?string $acc = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isExecuted = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isDelivered = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
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
    #[Attributes\Options\BooleanOption]
    public bool|string|null $histRate = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
