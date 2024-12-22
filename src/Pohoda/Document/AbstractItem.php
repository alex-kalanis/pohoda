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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


abstract class AbstractItem extends AbstractPart
{
    use Common\AddParameterTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
    )
    {
        // process home currency
        if (isset($data['homeCurrency'])) {
            $data['homeCurrency'] = new Type\CurrencyItem($namespacesPaths, $sanitizeEncoding, $data['homeCurrency'], $companyRegistrationNumber, $resolveOptions);
        }

        // process foreign currency
        if (isset($data['foreignCurrency'])) {
            $data['foreignCurrency'] = new Type\CurrencyItem($namespacesPaths, $sanitizeEncoding, $data['foreignCurrency'], $companyRegistrationNumber, $resolveOptions);
        }

        // process stock item
        if (isset($data['stockItem'])) {
            $data['stockItem'] = new Type\StockItem($namespacesPaths, $sanitizeEncoding, $data['stockItem'], $companyRegistrationNumber, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
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
