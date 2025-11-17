<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;

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
