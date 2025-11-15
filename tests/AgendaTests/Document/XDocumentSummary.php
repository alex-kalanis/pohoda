<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Document\AbstractSummary;

class XDocumentSummary extends AbstractSummary
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new Dtos\EmptyDto();
    }
}
