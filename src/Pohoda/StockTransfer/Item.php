<?php

declare(strict_types=1);

namespace kalanis\Pohoda\StockTransfer;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type\StockItem;

/**
 * @property ItemDto $data
 */
class Item extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process stock item
        if (isset($data->stockItem)) {
            $stockItem = new StockItem($this->dependenciesFactory);
            $stockItem
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->stockItem);
            $data->stockItem = $stockItem;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('pre:prevodkaItem', '', $this->namespace('pre'));

        $this->addElements($xml, $this->getDataElements(), 'pre');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
