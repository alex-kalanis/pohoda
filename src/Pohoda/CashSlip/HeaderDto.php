<?php

namespace kalanis\Pohoda\CashSlip;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\Options\ListOption(['saleVoucher', 'deposit', 'withdrawal']), Attributes\Options\DefaultOption('saleVoucher')]
    public ?string $prodejkaType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
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
    public ?string $kasa = null;
    public ?string $note = null;
    public ?string $intNote = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
