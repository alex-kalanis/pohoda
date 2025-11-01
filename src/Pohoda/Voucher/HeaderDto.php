<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public ?int $id = null;
    public ?string $extId = null;
    public ?string $voucherType = null;
    public ?string $storno = null;
    public ?string $cashAccount = null;
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
    public Type\Dtos\AddressDto|Type\MyAddress|null $partnerIdentity = null;
    public AbstractDto|AbstractAgenda|null $myIdentity = null;
    public ?string $symPar = null;
    public ?string $priceLevel = null;
    public ?string $centre = null;
    public ?string $activity = null;
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
    public \ArrayAccess|array $parameters = [];
    public ?string $validate = null;

}
