<?php

namespace kalanis\Pohoda\AddressBook;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public Type\Address|Type\Dtos\AddressDto|null $identity = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $region = null;
    #[Attributes\Options\StringOption(40)]
    public ?string $phone = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $mobil = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $fax = null;
    #[Attributes\Options\StringOption(98)]
    public ?string $email = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $web = null;
    #[Attributes\Options\StringOption(12)]
    public ?string $ICQ = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $Skype = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $GPS = null;
    #[Attributes\Options\FloatOption]
    public float|string|null $credit = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $priceIDS = null;
    #[Attributes\Options\IntegerOption]
    public ?int $maturity = null;
    public ?string $maturityCommitments = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\Options\StringOption(12)]
    public ?string $agreement = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\StringOption(8)]
    public ?string $ost1 = null;
    #[Attributes\Options\StringOption(8)]
    public ?string $ost2 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p1 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p2 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p3 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p4 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p5 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $p6 = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $markRecord = null;
    #[Attributes\Options\StringOption(64)]
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
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $centre = null;
    #[Attributes\RefElement]
    public ?string $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $adGroup = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
