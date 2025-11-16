<?php

namespace Riesenia\Pohoda\IntDoc;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    public ?string $symVar = null;
    public ?string $symPar = null;
    public ?string $originalDocumentNumber = null;
    public ?string $originalCorrectiveDocument = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $dateTax = null;
    public \DateTimeInterface|string|null $dateAccounting = null;
    public \DateTimeInterface|string|null $dateDelivery = null;
    public \DateTimeInterface|string|null $dateKVDPH = null;
    public \DateTimeInterface|string|null $dateKHDPH = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\RefElement]
    public ?string $classificationVAT = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPH = null;
    public ?string $numberKHDPH = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
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
    public bool|string|null $markRecord = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
