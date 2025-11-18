<?php

namespace kalanis\Pohoda\Offer;

use kalanis\Pohoda\Document;

class OfferDto extends Document\AbstractDocumentDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
