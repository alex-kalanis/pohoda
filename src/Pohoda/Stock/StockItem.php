<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Stock;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

/**
 * @property StockItemDto $data
 */
class StockItem extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process stockPriceItem
        if (!empty($data->stockPriceItem) && is_array($data->stockPriceItem)) {
            $data->stockPriceItem = \array_map(function (PriceDto $stockPriceItem) {
                $price = new Price($this->dependenciesFactory);
                $price->setDirectionalVariable($this->useOneDirectionalVariables)
                    ->setResolveOptions($this->resolveOptions)
                    ->setData($stockPriceItem);
                return $price;
            }, $data->stockPriceItem);
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('stk:stockItem', '', $this->namespace('stk'));

        $this->addElements($xml, $this->getDataElements(), 'stk');

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
