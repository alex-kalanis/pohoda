<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Document\AbstractHeader;

class XDocumentHeader extends AbstractHeader
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new Dtos\EmptyDto();
    }
}
