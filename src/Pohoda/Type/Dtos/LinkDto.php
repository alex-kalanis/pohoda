<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class LinkDto extends AbstractDto
{
    public ?string $sourceAgenda = null;
    public array|string|null $sourceDocument = null;
    public array|string|null $settingsSourceDocument = null;
}
