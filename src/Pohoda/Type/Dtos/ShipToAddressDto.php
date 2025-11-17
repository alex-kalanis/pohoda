<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class ShipToAddressDto extends AbstractDto
{
    #[Attributes\Options\StringOption(255)]
    public ?string $company = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $division = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $name = null;
    #[Attributes\Options\StringOption(45)]
    public ?string $city = null;
    #[Attributes\Options\StringOption(45)]
    public ?string $street = null;
    #[Attributes\Options\StringOption(15)]
    public ?string $zip = null;
    /** @var array<string|int, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $country = null;
    #[Attributes\Options\StringOption(40)]
    public ?string $phone = null;
    #[Attributes\Options\StringOption(98)]
    public ?string $email = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $defaultShipAddress = null;
}
