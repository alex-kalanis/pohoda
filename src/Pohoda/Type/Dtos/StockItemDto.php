<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class StockItemDto extends AbstractDto
{
    #[Attributes\RefElement]
    public ?string $store = null;
    /** @var string|AbstractAgenda|array<string, string|int|float|bool|array<string, string|int|float|bool>>|null */
    #[Attributes\RefElement]
    public string|AbstractAgenda|array|null $stockItem = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $insertAttachStock = null;
    #[Attributes\Options\BooleanOption]
    public bool|string|null $applyUserSettingsFilterOnTheStore = null;
    #[Attributes\Options\StringOption(40)]
    public ?string $serialNumber = null;
}
