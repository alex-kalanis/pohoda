<?php

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class PdfDto extends AbstractDto
{
    #[Attributes\Options\RequiredOption]
    public ?string $fileName = null;
}
