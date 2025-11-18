<?php

namespace tests\AgendaTests\Document;

use kalanis\Pohoda\Document\AbstractItem;
use kalanis\Pohoda\Common\Dtos;

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
