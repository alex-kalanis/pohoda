<?php

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class HeaderDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $date = null;
    #[Attributes\Options\DateOption(null, true)]
    public \DateTimeInterface|string|null $dateOfReceipt = null;
    #[Attributes\Options\StringOption(240)]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\Options\StringOption(20)]
    public ?string $symPar = null;
    #[Attributes\RefElement]
    public ?string $centre = null;
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
