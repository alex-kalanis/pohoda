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

abstract class AbstractSummary extends AbstractPart
{
    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process home currency
        if (isset($data['homeCurrency'])) {
            $homeCurrency = new Type\CurrencyHome($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['homeCurrency'] = $homeCurrency->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['homeCurrency']);
        }

        // process foreign currency
        if (isset($data['foreignCurrency'])) {
            $foreignCurrency = new Type\CurrencyForeign($this->namespacesPaths, $this->sanitizeEncoding, $this->companyRegistrationNumber, $this->resolveOptions, $this->normalizerFactory);
            $data['foreignCurrency'] = $foreignCurrency->setDirectionalVariable($this->useOneDirectionalVariables)->setData($data['foreignCurrency']);
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

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Summary', '', $this->namespace($this->namespace));

        $this->addElements($xml, $this->elements, $this->namespace);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);
    }
}
