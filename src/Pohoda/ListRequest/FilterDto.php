<?php

namespace Riesenia\Pohoda\ListRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;
use Riesenia\Pohoda\Common\Attributes;

class FilterDto extends AbstractDto
{
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
    public bool|string|null $internet = null;
    public ?string $company = null;
    public ?string $ico = null;
    public ?string $dic = null;
    public \DateTimeInterface|string|null $lastChanges = null;
    public \DateTimeInterface|string|null $dateFrom = null;
    public \DateTimeInterface|string|null $dateTill = null;
    #[Attributes\RefElement]
    public ?string $selectedNumbers = null;
    #[Attributes\RefElement]
    public ?string $selectedCompanys = null;
    #[Attributes\RefElement]
    public ?string $selectedIco = null;
}
