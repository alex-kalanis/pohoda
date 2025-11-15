<?php

namespace Riesenia\Pohoda\Contract;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class DescDto extends AbstractHeaderDto
{
    #[Attributes\RefElement]
    public ?string $number = null;
    public \DateTimeInterface|string|null $datePlanStart = null;
    public \DateTimeInterface|string|null $datePlanDelivery = null;
    public \DateTimeInterface|string|null $dateStart = null;
    public \DateTimeInterface|string|null $dateDelivery = null;
    public \DateTimeInterface|string|null $dateWarranty = null;
    public ?string $text = null;
    public Type\Dtos\AddressDto|Type\Address|null $partnerIdentity = null;
    #[Attributes\RefElement]
    public array|string|null $responsiblePerson = null;
    public ?string $note = null;
    public \ArrayAccess|array $parameters = [];
}
