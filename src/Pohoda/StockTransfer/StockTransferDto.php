<?php

namespace Riesenia\Pohoda\StockTransfer;

use Riesenia\Pohoda\Common\Dtos\AbstractItemDto;

class StockTransferDto extends AbstractItemDto
{
    public Header|HeaderDto|null $header = null;
    /** @var \ArrayAccess<Item|ItemDto>|array<Item|ItemDto> */
    public \ArrayAccess|array $prevodkaDetail = [];
}
