<?php

namespace kalanis\Pohoda\IntDoc;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symVar = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    public ?string $originalDocumentNumber = null;
    public ?string $originalCorrectiveDocument = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateTax = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateAccounting = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateDelivery = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateKVDPH = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateKHDPH = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $numberKHDPH = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $liquidation = null;
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
    public ?string $intNote = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $markRecord = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
