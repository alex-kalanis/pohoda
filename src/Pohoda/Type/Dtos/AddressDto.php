<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type;

class AddressDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public ?int $id = null;
    #[Attributes\RefElement]
    public ?string $extId = null;
    public AddressTypeDto|Type\AddressType|null $address = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $addressLinkToAddress = null;
    public ShipToAddressDto|Type\ShipToAddressType|null $shipToAddress = null;
}
