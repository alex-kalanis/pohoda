<?php

namespace Riesenia\Pohoda\IssueSlip;

use Riesenia\Pohoda\Document;
use Riesenia\Pohoda\Type;

class IssueSlipDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    /** @var array<Type\Link|Type\Dtos\LinkDto> */
    public array $links = [];
    public Summary|SummaryDto|null $summary = null;
}
