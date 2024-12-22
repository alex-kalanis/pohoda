<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;


use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;


class Supplier extends AbstractAgenda
{

    public function getImportRoot(): string
    {
        return 'lst:supplier';
    }

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
        // process stockItem
        if (isset($data['stockItem'])) {
            $data['stockItem'] = new Supplier\StockItem($namespacesPaths, $sanitizeEncoding, $data['stockItem'], $companyRegistrationNumber, $resolveOptions);
        }

        // process suppliers
        if (isset($data['suppliers']) && is_array($data['suppliers'])) {
            $data['suppliers'] = \array_map(function ($supplier) use ($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $resolveOptions) {
                return new Supplier\SupplierItem($namespacesPaths, $sanitizeEncoding, $supplier['supplierItem'], $companyRegistrationNumber, $resolveOptions);
            }, $data['suppliers']);
        }

        parent::__construct($namespacesPaths, $sanitizeEncoding, $data, $companyRegistrationNumber, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:supplier', '', $this->namespace('sup'));
        $xml->addAttribute('version', '2.0');

        $this->addElements($xml, ['stockItem', 'suppliers'], 'sup');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined(['stockItem', 'suppliers']);
    }
}
