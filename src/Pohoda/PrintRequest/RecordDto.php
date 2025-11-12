<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;

class RecordDto extends AbstractHeaderDto
{
    #[Attributes\JustAttribute]
    public ?string $agenda = null;
    public FilterDto|Filter|null $filter = null;
}
