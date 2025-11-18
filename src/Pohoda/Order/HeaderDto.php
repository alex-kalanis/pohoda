<?php

namespace kalanis\Pohoda\Order;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $extId = null;
    #[Attributes\Options\ListOption(['receivedOrder', 'issuedOrder']), Attributes\Options\DefaultOption('receivedOrder')]
    public ?string $orderType = null;
    /** @var array<string, string|int|float|bool>|string|null */
    #[Attributes\RefElement]
    public array|string|null $number = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $numberOrder = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateDelivery = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateFrom = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateTo = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isExecuted = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isReserved = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
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
    #[Attributes\Options\BooleanOption]
    public bool|string|null $markRecord = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $histRate = null;
    #[Attributes\ResponseDirection, Attributes\Options\IntegerOption]
    public ?int $id = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $isDelivered = null;
    #[Attributes\ResponseDirection, Attributes\Options\BooleanOption]
    public bool|string|null $permanentDocument = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
