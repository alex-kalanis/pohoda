<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractDto;

class PdfDto extends AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $fileName = null;
}
