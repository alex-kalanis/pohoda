<?php

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $time = null;
    public \DateTimeInterface|string|null $dateOfReceipt = null;
    public \DateTimeInterface|string|null $timeOfReceipt = null;
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public array|string|null $store = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\RefElement]
    public ?string $centreSource = null;
    public ?string $centreDestination = null;
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $note = null;
    public ?string $intNote = null;
}
