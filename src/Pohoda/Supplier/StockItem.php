<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Supplier;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class StockItem extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:stockItem', '', $this->namespace('sup'));

        $this->addElements($xml, $this->getDataElements(), 'typ');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new StockItemDto();
    }
}
