<?php

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\Common\Dtos;

class PictureDto extends Dtos\AbstractDto
{
    public ?string $filepath = null;
    public ?string $description = null;
    public ?int $order = null;
    public ?bool $default = null;
}
