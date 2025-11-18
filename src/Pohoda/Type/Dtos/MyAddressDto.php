<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Dtos\AbstractDto;
use kalanis\Pohoda\Type;

class MyAddressDto extends AbstractDto
{
    public AddressInternetTypeDto|Type\AddressInternetType|null $address = null;
    public EstablishmentTypeDto|Type\EstablishmentType|null $establishment = null;
}
