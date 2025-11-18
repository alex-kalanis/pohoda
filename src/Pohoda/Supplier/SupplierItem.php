<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Supplier;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property SupplierDto $data
 */
class SupplierItem extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:supplierItem', '', $this->namespace('sup'));

        // handle default
        if (isset($this->data->default)) {
            $xml->addAttribute('default', strval($this->data->default));
            $this->data->default = null;
        }

        $this->addElements($xml, $this->getDataElements(), 'sup');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new SupplierItemDto();
    }
}
