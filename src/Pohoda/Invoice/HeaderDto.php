<?php

namespace kalanis\Pohoda\Invoice;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $extId = null;
    #[Attributes\Options\ListOption(['issuedInvoice', 'issuedCreditNotice', 'issuedDebitNote', 'issuedAdvanceInvoice', 'receivable', 'issuedProformaInvoice', 'penalty', 'issuedCorrectiveTax', 'receivedInvoice', 'receivedCreditNotice', 'receivedDebitNote', 'receivedAdvanceInvoice', 'commitment', 'receivedProformaInvoice', 'receivedCorrectiveTax']), Attributes\Options\DefaultOption('issuedInvoice')]
    public ?string $invoiceType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symVar = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $originalDocument = null;
    public ?string $originalDocumentNumber = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateTax = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateAccounting = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateKHDPH = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateDue = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateApplicationVAT = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateDelivery = null;
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
    #[Attributes\RefElement]
    public ?string $order = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $numberOrder = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateOrder = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $account = null;
    #[Attributes\Options\StringOption(4)]
    public ?string $symConst = null;
    #[Attributes\Options\StringOption(16)]
    public ?string $symSpec = null;
    #[Attributes\RefElement]
    public ?string $paymentAccount = null;
    #[Attributes\Options\BooleanOption]
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
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateTaxOriginalDocumentMOSS = null;
    public ?string $note = null;
    #[Attributes\RefElement]
    public ?string $carrier = null;
    public ?string $intNote = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $postponedIssue = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $histRate = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
