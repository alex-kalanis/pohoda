<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Document;

class VoucherDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
