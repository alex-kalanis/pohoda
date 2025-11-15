<?php

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class StockTransferDto extends AbstractItemDto
{
    public Header|HeaderDto|null $header = null;
    /** @var array<Item|ItemDto> */
    public array $prevodkaDetail = [];
}
