<?php

namespace kalanis\Pohoda\CashSlip;

use kalanis\Pohoda\Document;

class CashSlipDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
