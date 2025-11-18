<?php

namespace kalanis\Pohoda\StockTransfer;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Type;

class HeaderDto extends Dtos\AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\TimeOption]
    public \DateTimeInterface|string|null $time = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateOfReceipt = null;
    #[Attributes\Options\TimeOption]
    public \DateTimeInterface|string|null $timeOfReceipt = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $store = null;
    #[Attributes\Options\StringOption(48)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\RefElement]
    public ?string $centreSource = null;
    public ?string $centreDestination = null;
    /** @var array<string, string|int|float|bool|array<string, string|int|float|bool>>|string|null */
    #[Attributes\RefElement]
    public array|string|null $activity = null;
    #[Attributes\RefElement]
    public ?string $contract = null;
    public ?string $note = null;
    public ?string $intNote = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
