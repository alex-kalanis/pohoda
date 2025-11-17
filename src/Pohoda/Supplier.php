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
 * @property Supplier\SupplierDto $data
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
    public function setData(Common\Dtos\AbstractDto $data): parent
    {
        // process stockItem
        if (isset($data->stockItem)) {
            $stockItem = new Supplier\StockItem($this->dependenciesFactory);
            $stockItem
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->stockItem);
            $data->stockItem = $stockItem;
        }

        // process suppliers
        if (!empty($data->suppliers) && is_array($data->suppliers)) {
            $data->suppliers = \array_map(function (Supplier\SupplierItemDto $item) {
                $supplierItem = new Supplier\SupplierItem($this->dependenciesFactory);
                $supplierItem
                    ->setDirectionalVariable($this->useOneDirectionalVariables)
                    ->setResolveOptions($this->resolveOptions)
                    ->setData($item);
                return $supplierItem;
            }, $data->suppliers);
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

        $this->addElements($xml, $this->getDataElements(), 'sup');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Supplier\SupplierDto();
    }
}
