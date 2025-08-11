<?php

namespace tests\AgendaTests\Document;

use Riesenia\Pohoda\Document\AbstractItem;

class XDocumentItem extends AbstractItem
{
    protected array $elements = ['homeCurrency', 'foreignCurrency', 'stockItem'];
}
