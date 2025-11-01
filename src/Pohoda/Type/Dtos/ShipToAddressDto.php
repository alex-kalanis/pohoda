<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class ShipToAddressDto extends AbstractDto
{
    public ?string $company = null;
    public ?string $division = null;
    public ?string $name = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $zip = null;
    public ?string $country = null;
    public ?string $phone = null;
    public ?string $email = null;
    public ?string $defaultShipAddress = null;
}
