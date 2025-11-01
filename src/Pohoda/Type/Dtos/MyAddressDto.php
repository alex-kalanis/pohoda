<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Type;


class MyAddressDto extends AbstractDto
{
    public AddressInternetTypeDto|Type\AddressInternetType|null $address = null;
    public EstablishmentTypeDto|Type\EstablishmentType|null $establishment = null;
}
