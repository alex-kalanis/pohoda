<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Document;

class BankDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
