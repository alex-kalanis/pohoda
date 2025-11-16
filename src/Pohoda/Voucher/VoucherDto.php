<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document;

class VoucherDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
