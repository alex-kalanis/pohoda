<?php

namespace Riesenia\Pohoda\AddressBook;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public Type\Address|Type\Dtos\AddressDto|null $identity = null;
    public ?string $region = null;
    public ?string $phone = null;
    public ?string $mobil = null;
    public ?string $fax = null;
    public ?string $email = null;
    public ?string $web = null;
    public ?string $ICQ = null;
    public ?string $Skype = null;
    public ?string $GPS = null;
    public float|string|null $credit = null;
    public ?string $priceIDS = null;
    public ?int $maturity = null;
    public ?string $maturityCommitments = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    public ?string $agreement = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public ?string $ost1 = null;
    public ?string $ost2 = null;
    public bool|string|null $p1 = null;
    public bool|string|null $p2 = null;
    public bool|string|null $p3 = null;
    public bool|string|null $p4 = null;
    public bool|string|null $p5 = null;
    public bool|string|null $p6 = null;
    public bool|string|null $markRecord = null;
    public ?string $message = null;
    public ?string $note = null;
    public ?string $intNote = null;
    #[Attributes\RefElement]
    public ?string $accountingReceivedInvoice = null;
    #[Attributes\RefElement]
    public ?string $accountingIssuedInvoice = null;
    #[Attributes\RefElement]
    public ?string $classificationVATReceivedInvoice = null;
    #[Attributes\RefElement]
    public ?string $classificationVATIssuedInvoice = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPHReceivedInvoice = null;
    #[Attributes\RefElement]
    public ?string $classificationKVDPHIssuedInvoice = null;
    #[Attributes\RefElement]
    public ?string $accountForInvoicing = null;
    #[Attributes\RefElement]
    public ?string $foreignCurrency = null;
    #[Attributes\RefElement]
    public array|string|null $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $adGroup = null;
    public array $parameters = [];
}
