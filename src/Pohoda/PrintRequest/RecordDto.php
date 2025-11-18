<?php

namespace kalanis\Pohoda\PrintRequest;

use kalanis\Pohoda\Common\Attributes;
use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;

class RecordDto extends AbstractHeaderDto
{
    #[Attributes\JustAttribute, Attributes\Options\RequiredOption]
    public ?string $agenda = null;
    #[Attributes\Options\RequiredOption]
    public FilterDto|Filter|null $filter = null;
}
