<?php

namespace Riesenia\Pohoda\PrintRequest;

use Riesenia\Pohoda\Common\Attributes;
use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;

class RecordDto extends AbstractHeaderDto
{
    #[Attributes\JustAttribute, Attributes\Options\RequiredOption]
    public ?string $agenda = null;
    #[Attributes\Options\RequiredOption]
    public FilterDto|Filter|null $filter = null;
}
