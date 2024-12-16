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

abstract class AbstractItem extends AbstractPart
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(Common\NamespacesPaths $namespacesPaths, array $data, string $ico, bool $resolveOptions = true)
    {
        // process home currency
        if (isset($data['homeCurrency'])) {
            $data['homeCurrency'] = new Type\CurrencyItem($namespacesPaths, $data['homeCurrency'], $ico, $resolveOptions);
        }

        // process foreign currency
        if (isset($data['foreignCurrency'])) {
            $data['foreignCurrency'] = new Type\CurrencyItem($namespacesPaths, $data['foreignCurrency'], $ico, $resolveOptions);
        }

        // process stock item
        if (isset($data['stockItem'])) {
            $data['stockItem'] = new Type\StockItem($namespacesPaths, $data['stockItem'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $data, $ico, $resolveOptions);
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

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), $this->namespace);

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
