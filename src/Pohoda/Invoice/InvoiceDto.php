<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class InvoiceDto extends Dtos\AbstractDto
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
