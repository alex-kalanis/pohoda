<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $extId = null;
    public ?string $invoiceType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public ?string $symVar = null;
    public ?string $originalDocument = null;
    public ?string $originalDocumentNumber = null;
    public ?string $symPar = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $dateTax = null;
    public \DateTimeInterface|string|null $dateAccounting = null;
    public \DateTimeInterface|string|null $dateKHDPH = null;
    public \DateTimeInterface|string|null $dateDue = null;
    public \DateTimeInterface|string|null $dateApplicationVAT = null;
    public \DateTimeInterface|string|null $dateDelivery = null;
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
    #[Attributes\RefElement]
    public ?string $order = null;
    public ?string $numberOrder = null;
    public \DateTimeInterface|string|null $dateOrder = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $account = null;
    public ?string $symConst = null;
    public ?string $symSpec = null;
    #[Attributes\RefElement]
    public ?string $paymentAccount = null;
    public bool|string|null $paymentTerminal = null;
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
    public \DateTimeInterface|string|null $dateTaxOriginalDocumentMOSS = null;
    public ?string $note = null;
    #[Attributes\RefElement]
    public ?string $carrier = null;
    public ?string $intNote = null;
    public bool|string|null $postponedIssue = null;
    public bool|string|null $histRate = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
