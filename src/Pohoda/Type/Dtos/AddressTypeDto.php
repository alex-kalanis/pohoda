<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class AddressTypeDto extends AbstractDto
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
    #[Attributes\Options\StringOption(15)]
    public ?string $ico = null;
    #[Attributes\Options\StringOption(18)]
    public ?string $dic = null;
    #[Attributes\Options\ListOption(['payer', 'non-payer', ''])]
    public ?string $VATPayerType = null;
    #[Attributes\Options\StringOption(18)]
    public ?string $icDph = null;
    /** @var array<string|int, string>|string|null */
    #[Attributes\RefElement]
    public array|string|null $country = null;
    #[Attributes\Options\StringOption(40)]
    public ?string $phone = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $mobilPhone = null;
    #[Attributes\Options\StringOption(24)]
    public ?string $fax = null;
    #[Attributes\Options\StringOption(98)]
    public ?string $email = null;
}
