<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;


class AddressDto extends AbstractDto
{
    public ?int $id = null;
    public ?string $extId = null;
    public AddressTypeDto|Type\AddressType|null $address = null;
    public ?string $addressLinkToAddress = null;
    public ShipToAddressDto|Type\ShipToAddressType|null $shipToAddress = null;
}
