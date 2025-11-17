<?php

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\Options\ListOption(['receivedOffer', 'issuedOffer']), Attributes\Options\DefaultOption('receivedOffer')]
    public ?string $offerType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $validTill = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
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
    #[Attributes\Options\BooleanOption]
    public bool|string|null $isExecuted = null;
    public ?string $details = null;
    public ?string $note = null;
    public ?string $intNote = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $markRecord = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
