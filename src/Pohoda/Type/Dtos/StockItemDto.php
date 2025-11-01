<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    public ?string $store = null;
    public string|AbstractAgenda|array|null $stockItem = null;
    public ?string $insertAttachStock = null;
    public ?string $applyUserSettingsFilterOnTheStore = null;
    public ?string $serialNumber = null;
}
