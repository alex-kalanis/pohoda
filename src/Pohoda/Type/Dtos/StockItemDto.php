<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $store = null;
    #[Attributes\RefElement]
    public string|AbstractAgenda|array|null $stockItem = null;
    public bool|string|null $insertAttachStock = null;
    public bool|string|null $applyUserSettingsFilterOnTheStore = null;
    public ?string $serialNumber = null;
}
