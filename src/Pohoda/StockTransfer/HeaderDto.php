<?php

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    public ?string $number = null;
    public \DateTimeInterface|string|null $date = null;
    public \DateTimeInterface|string|null $time = null;
    public \DateTimeInterface|string|null $dateOfReceipt = null;
    public \DateTimeInterface|string|null $timeOfReceipt = null;
    public ?string $symPar = null;
    public array|string|null $store = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    public ?string $centreSource = null;
    public ?string $centreDestination = null;
    public array|string|null $activity = null;
    public ?string $contract = null;
    public ?string $note = null;
    public ?string $intNote = null;
}
