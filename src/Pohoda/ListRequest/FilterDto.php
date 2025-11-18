<?php

namespace kalanis\Pohoda\ListRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class FilterDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $id = null;
    #[Attributes\RefElement]
    public ?string $extId = null;
    public ?string $code = null;
    public ?string $EAN = null;
    public ?string $name = null;
    /** @var array<string, string|int|float|bool>|string|null */
    #[Attributes\RefElement]
    public array|string|null $storage = null;
    #[Attributes\RefElement]
    public ?string $store = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $internet = null;
    public ?string $company = null;
    public ?string $ico = null;
    public ?string $dic = null;
    #[Attributes\Options\DateTimeOption]
    public \DateTimeInterface|string|null $lastChanges = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateFrom = null;
    #[Attributes\Options\DateOption]
    public \DateTimeInterface|string|null $dateTill = null;
    #[Attributes\RefElement]
    public ?string $selectedNumbers = null;
    #[Attributes\RefElement]
    public ?string $selectedCompanys = null;
    #[Attributes\RefElement]
    public ?string $selectedIco = null;
}
