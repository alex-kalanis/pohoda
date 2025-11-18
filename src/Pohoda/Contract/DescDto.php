<?php

namespace kalanis\Pohoda\Contract;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class DescDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $datePlanStart = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $datePlanDelivery = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateStart = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateDelivery = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateWarranty = null;
    #[Attributes\Options\StringOption(90), Attributes\Options\RequiredOption]
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    /** @var array<string, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $responsiblePerson = null;
    public ?string $note = null;
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
