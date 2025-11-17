<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class EstablishmentTypeDto extends AbstractDto
{
    #[Attributes\Options\StringOption(255)]
    public ?string $company = null;
    #[Attributes\Options\StringOption(45)]
    public ?string $city = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $street = null;
    #[Attributes\Options\StringOption(15)]
    public ?string $zip = null;
}
