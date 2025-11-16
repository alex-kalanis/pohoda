<?php

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Document;

class CashSlipDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
