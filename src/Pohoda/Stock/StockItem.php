<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Stock;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

class StockItem extends AbstractAgenda
{
    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // process stockPriceItem
        if (is_array($data->stockPriceItem) && !empty($data->stockPriceItem)) {
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
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        $resolver->setNormalizer('id', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('count', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('quantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new StockItemDto();
    }
}
