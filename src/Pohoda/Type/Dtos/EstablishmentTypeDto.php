<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class EstablishmentTypeDto extends AbstractDto
{
    public ?string $company = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $zip = null;
}
