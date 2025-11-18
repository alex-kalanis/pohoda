<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class RecyclingContrib extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:recyclingContrib', '', $this->namespace('stk'));

        $this->addElements($xml, $this->getDataElements(), 'stk');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new RecyclingContribDto();
    }
}
