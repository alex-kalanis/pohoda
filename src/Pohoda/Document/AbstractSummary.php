<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Document;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Type;
use kalanis\PohodaException;

/**
 * @property Common\Dtos\AbstractSummaryDto $data
 */
abstract class AbstractSummary extends AbstractPart
{
    /**
     * {@inheritdoc}
     */
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process home currency
        if (isset($data->homeCurrency)) {
            $homeCurrency = new Type\CurrencyHome($this->dependenciesFactory);
            $homeCurrency
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->homeCurrency);
            $data->homeCurrency = $homeCurrency;
        }

        // process foreign currency
        if (isset($data->foreignCurrency)) {
            $foreignCurrency = new Type\CurrencyForeign($this->dependenciesFactory);
            $foreignCurrency
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->foreignCurrency);
            $data->foreignCurrency = $foreignCurrency;
        }

        return parent::setData($data);
    }

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

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Summary', '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->getDataElements(), $this->namespace);

        return $xml;
    }
}
