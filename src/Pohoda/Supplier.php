<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda;

/**
 * @property array{
 *     stockItem?: Supplier\StockItem,
 *     suppliers?: Supplier\SupplierItem,
 * } $data
 */
class Supplier extends AbstractAgenda
{
    public function getImportRoot(): string
    {
        return 'lst:supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function setData(array $data): parent
    {
        // process stockItem
        if (isset($data['stockItem'])) {
            $stockItem = new Supplier\StockItem($this->dependenciesFactory);
            $stockItem->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($data['stockItem']);
            $data['stockItem'] = $stockItem;
        }

        // process suppliers
        if (isset($data['suppliers']) && is_array($data['suppliers'])) {
            $data['suppliers'] = \array_map(function ($supplier) {
                $supplierItem = new Supplier\SupplierItem($this->dependenciesFactory);
                $supplierItem->setDirectionalVariable($this->useOneDirectionalVariables)->setResolveOptions($this->resolveOptions)->setData($supplier['supplierItem']);
                return $supplierItem;
            }, $data['suppliers']);
        }

        return parent::setData($data);
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
