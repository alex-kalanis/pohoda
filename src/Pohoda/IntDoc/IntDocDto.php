<?php

namespace Riesenia\Pohoda\IntDoc;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class IntDocDto extends Dtos\AbstractDto
{
    public Type\TaxDocument|Type\Dtos\TaxDocumentDto|null $taxDocument = null;
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
