<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class ShipToAddressDto extends AbstractDto
{
    public ?string $company = null;
    public ?string $division = null;
    public ?string $name = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $zip = null;
    /** @var array<string|int, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $country = null;
    public ?string $phone = null;
    public ?string $email = null;
    public bool|string|null $defaultShipAddress = null;
}
