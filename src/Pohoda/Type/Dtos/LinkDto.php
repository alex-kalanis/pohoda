<?php

namespace Riesenia\Pohoda\Type\Dtos;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class LinkDto extends AbstractDto
{
    public ?string $sourceAgenda = null;
    public ?string $sourceDocument = null;
    public ?string $settingsSourceDocument = null;
}
