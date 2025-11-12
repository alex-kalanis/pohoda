<?php

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class InvoiceDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $details = [];
    /** @var \ArrayAccess<Type\Link|Type\Dtos\LinkDto>|array<Type\Link|Type\Dtos\LinkDto> */
    public \ArrayAccess|array $links = [];
    /** @var \ArrayAccess<AdvancePaymentItem|AdvancePaymentItemDto>|array<AdvancePaymentItem|AdvancePaymentItemDto> */
    public \ArrayAccess|array $invoiceDetail = [];
    public Summary|SummaryDto|null $summary = null;
}
