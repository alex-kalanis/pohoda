<?php

namespace kalanis\Pohoda\Type\Dtos;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class AddressInternetTypeDto extends AbstractDto
{
    #[Attributes\Options\StringOption(255)]
    public ?string $company = null;
    #[Attributes\Options\StringOption(7)]
    public ?string $title = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $surname = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $name = null;
    #[Attributes\Options\StringOption(45)]
    public ?string $city = null;
    #[Attributes\Options\StringOption(45)]
    public ?string $street = null;
    #[Attributes\Options\StringOption(10)]
    public ?string $number = null;
    #[Attributes\Options\StringOption(15)]
    public ?string $zip = null;
    #[Attributes\Options\StringOption(15)]
    public ?string $ico = null;
    #[Attributes\Options\StringOption(18)]
    public ?string $dic = null;
    #[Attributes\Options\StringOption(18)]
    public ?string $icDph = null;
    #[Attributes\Options\StringOption(40)]
    public ?string $phone = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $mobilPhone = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $fax = null;
    #[Attributes\Options\StringOption(64)]
    public ?string $email = null;
    #[Attributes\Options\StringOption(32)]
    public ?string $www = null;
}
