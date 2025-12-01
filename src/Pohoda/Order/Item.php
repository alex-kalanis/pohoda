<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Order;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractItem;
use kalanis\PohodaException;

class Item extends AbstractItem
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new PohodaException('Namespace not set.');
        }

        if (is_null($this->nodePrefix)) {
            throw new PohodaException('Node name prefix not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Item', '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->getDataElements(), $this->namespace);

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
