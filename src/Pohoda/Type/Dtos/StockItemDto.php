<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    public ?string $store = null;
    public string|AbstractAgenda|array|null $stockItem = null;
    public bool|string|null $insertAttachStock = null;
    public bool|string|null $applyUserSettingsFilterOnTheStore = null;
    public ?string $serialNumber = null;
}
