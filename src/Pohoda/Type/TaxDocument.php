<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;


use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class TaxDocument extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [];

    /** @var string[] */
    protected array $elements = ['sourceLiquidation'];

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
        // process source liquidation
        if (isset($data['sourceLiquidation'])) {
            $data['sourceLiquidation'] = new SourceLiquidation($namespacesPaths, $sanitizeEncoding, $data['sourceLiquidation'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('int:taxDocument', '', $this->namespace('int'));

        $this->addElements($xml, $this->elements, 'int');

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
