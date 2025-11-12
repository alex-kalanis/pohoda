<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class PdfDto extends AbstractDto
{
    public ?string $fileName = null;
}
