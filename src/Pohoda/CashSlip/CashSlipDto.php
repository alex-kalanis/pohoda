<?php

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Common\Dtos;

class CashSlipDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
