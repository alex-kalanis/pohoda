<?php

namespace Riesenia\Pohoda\IssueSlip;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Type;

class IssueSlipDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $details = [];
    /** @var \ArrayAccess<Type\Link|Type\Dtos\LinkDto>|array<Type\Link|Type\Dtos\LinkDto> */
    public \ArrayAccess|array $links = [];
    public Summary|SummaryDto|null $summary = null;
}
