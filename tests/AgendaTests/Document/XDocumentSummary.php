<?php

namespace tests\AgendaTests\Document;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractSummary;

class XDocumentSummary extends AbstractSummary
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new Dtos\EmptyDto();
    }
}
