<?php

namespace tests\AgendaTests\Document;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractHeader;

class XDocumentHeader extends AbstractHeader
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new XDocumentHeaderDto();
    }
}
