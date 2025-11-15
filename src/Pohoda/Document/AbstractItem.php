<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Document;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Type;

/**
 * @property Common\Dtos\AbstractItemDto $data
 */
abstract class AbstractItem extends AbstractPart
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // process home currency
        if (isset($data->homeCurrency)) {
            $homeCurrency = new Type\CurrencyItem($this->dependenciesFactory);
            $homeCurrency
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->homeCurrency);
            $data->homeCurrency = $homeCurrency;
        }

        // process foreign currency
        if (isset($data->foreignCurrency)) {
            $foreignCurrency = new Type\CurrencyItem($this->dependenciesFactory);
            $foreignCurrency
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->foreignCurrency);
            $data->foreignCurrency = $foreignCurrency;
        }

        // process stock item
        if (isset($data->stockItem)) {
            $stockItem = new Type\StockItem($this->dependenciesFactory);
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
        if (is_null($this->namespace)) {
            throw new \LogicException('Namespace not set.');
        }

        if (is_null($this->nodePrefix)) {
            throw new \LogicException('Node name prefix not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Item', '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->getDataElements(), $this->namespace);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());
    }
}
