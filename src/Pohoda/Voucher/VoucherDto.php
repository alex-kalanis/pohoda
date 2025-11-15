<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class VoucherDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
