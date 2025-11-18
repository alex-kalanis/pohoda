<?php

namespace kalanis\Pohoda\IntDoc;

use kalanis\Pohoda\Document;
use kalanis\Pohoda\Type;

class IntDocDto extends Document\AbstractDocumentDto
{
    public Type\TaxDocument|Type\Dtos\TaxDocumentDto|null $taxDocument = null;
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
