<?php

namespace kalanis\Pohoda\Invoice;

use kalanis\Pohoda\Document;
use kalanis\Pohoda\Type;

class InvoiceDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    /** @var array<Type\Link|Type\Dtos\LinkDto> */
    public array $links = [];
    /** @var array<AdvancePaymentItem|AdvancePaymentItemDto> */
    public array $invoiceDetail = [];
    public Summary|SummaryDto|null $summary = null;
}
