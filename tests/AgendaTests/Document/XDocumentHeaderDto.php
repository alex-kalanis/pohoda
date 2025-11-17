<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Common\Dtos\AbstractHeaderDto;
use Riesenia\Pohoda\Type;

class XDocumentHeaderDto extends AbstractHeaderDto
{
    /** @var array<Type\Parameter|Type\Dtos\ParameterDto> */
    public array $parameters = [];
}
