<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class AddressTypeDto extends AbstractDto
{
    public ?string $company = null;
    public ?string $division = null;
    public ?string $name = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $zip = null;
    public ?string $ico = null;
    public ?string $dic = null;
    public ?string $VATPayerType = null;
    public ?string $icDph = null;
    public ?string $country = null;
    public ?string $phone = null;
    public ?string $mobilPhone = null;
    public ?string $fax = null;
    public ?string $email = null;
}
