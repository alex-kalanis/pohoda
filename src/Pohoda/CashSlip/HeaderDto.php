<?php

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    public ?string $prodejkaType = null;
    #[Attributes\RefElement]
    public ?string $number = null;
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\RefElement]
    public ?string $accounting = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\RefElement]
    public ?string $paymentType = null;
    #[Attributes\RefElement]
    public ?string $priceLevel = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    #[Attributes\RefElement]
    public ?string $kasa = null;
    public ?string $note = null;
    public ?string $intNote = null;
    public array $parameters = [];
}
