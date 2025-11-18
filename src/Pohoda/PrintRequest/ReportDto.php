<?php

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractDto;

class ReportDto extends AbstractDto
{
    #[Attributes\Options\IntegerOption]
    public int|string|null $id = null;
}
