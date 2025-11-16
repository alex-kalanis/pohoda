<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public ?int $id = null;
    public ?string $extId = null;
    public ?string $voucherType = null;
    public ?string $storno = null;
    #[Attributes\RefElement]
    public ?string $cashAccount = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public ?string $originalDocument = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $datePayment = null;
    public \DateTimeInterface|string|null $dateTax = null;
    public \DateTimeInterface|string|null $dateKHDPH = null;
    public ?string $accounting = null;
    public ?string $classificationVAT = null;
    public ?string $classificationKVDPH = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public Type\Dtos\MyAddressDto|Type\MyAddress|null $myIdentity = null;
    public ?string $symPar = null;
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $regVATinEU = null;
    public ?string $MOSS = null;
    public ?string $evidentiaryResourcesMOSS = null;
    public ?string $note = null;
    public ?string $intNote = null;
    public ?string $histRate = null;
    public ?string $lock1 = null;
    public ?string $lock2 = null;
    public ?string $markRecord = null;
    public ?string $labels = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
    public ?string $validate = null;
}
