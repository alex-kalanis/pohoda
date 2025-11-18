<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Invoice;

use kalanis\Pohoda\Common;

class AdvancePaymentItem extends Item
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('inv:invoiceAdvancePaymentItem', '', $this->namespace('inv'));

        $this->addElements($xml, $this->getDataElements(), 'inv');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new AdvancePaymentItemDto();
    }
}
