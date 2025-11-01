<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class AddressInternetTypeDto extends AbstractDto
{
    public ?string $company = null;
    public ?string $title = null;
    public ?string $surname = null;
    public ?string $name = null;
    public ?string $city = null;
    public ?string $street = null;
    public ?string $number = null;
    public ?string $zip = null;
    public ?string $ico = null;
    public ?string $dic = null;
    public ?string $icDph = null;
    public ?string $phone = null;
    public ?string $mobilPhone = null;
    public ?string $fax = null;
    public ?string $email = null;
    public ?string $www = null;
}
