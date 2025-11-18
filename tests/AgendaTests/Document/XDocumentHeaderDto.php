<?php

namespace tests\AgendaTests\Document;

use kalanis\Pohoda\Common\Dtos\AbstractHeaderDto;
use kalanis\Pohoda\Type;

class XDocumentHeaderDto extends AbstractHeaderDto
{
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
