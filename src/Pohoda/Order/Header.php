<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Order;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractHeader;
use kalanis\PohodaException;

class Header extends AbstractHeader
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

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Header', '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->getDataElements(), $this->namespace);

        return $xml;
    }

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
