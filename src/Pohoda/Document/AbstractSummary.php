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


abstract class AbstractSummary extends AbstractPart
{
    /**
     * {@inheritdoc}
     */
    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        array $data,
        string $ico,
        bool $resolveOptions = true,
    )
    {
        // process home currency
        if (isset($data['homeCurrency'])) {
            $data['homeCurrency'] = new Type\CurrencyHome($namespacesPaths, $sanitizeEncoding, $data['homeCurrency'], $ico, $resolveOptions);
        }

        // process foreign currency
        if (isset($data['foreignCurrency'])) {
            $data['foreignCurrency'] = new Type\CurrencyForeign($namespacesPaths, $sanitizeEncoding, $data['foreignCurrency'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $ico, $resolveOptions);
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
