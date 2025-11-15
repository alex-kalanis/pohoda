<?php

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\Dtos;

class BankDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
