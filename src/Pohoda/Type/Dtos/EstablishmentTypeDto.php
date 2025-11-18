<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

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
