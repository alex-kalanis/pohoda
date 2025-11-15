<?php

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\Dtos;

class OfferDto extends Dtos\AbstractDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $details = [];
    public Summary|SummaryDto|null $summary = null;
}
