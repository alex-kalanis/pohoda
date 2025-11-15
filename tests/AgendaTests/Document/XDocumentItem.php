<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Document\AbstractItem;
use Riesenia\Pohoda\Common\Dtos;

class XDocumentItem extends AbstractItem
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new XDocumentItemDto();
    }
}
