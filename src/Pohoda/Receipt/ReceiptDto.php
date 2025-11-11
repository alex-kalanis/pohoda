<?php

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\Dtos;

class ReceiptDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
