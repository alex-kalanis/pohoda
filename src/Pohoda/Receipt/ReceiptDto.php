<?php

namespace kalanis\Pohoda\Receipt;

use kalanis\Pohoda\Document;

class ReceiptDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
