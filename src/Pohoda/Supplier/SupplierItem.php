<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Supplier;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

/**
 * @property SupplierDto $data
 */
class SupplierItem extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = [
        'refAd',
        'currency',
        'deliveryPeriod',
    ];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:supplierItem', '', $this->namespace('sup'));

        // handle default
        if (isset($this->data->default)) {
            $xml->addAttribute('default', strval($this->data->default));
            $this->data->default = null;
        }

        $this->addElements($xml, $this->getDataElements(), 'sup');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        $resolver->setNormalizer('default', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('orderCode', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('orderName', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('purchasingPrice', $this->dependenciesFactory->getNormalizerFactory()->getClosure('number'));
        $resolver->setNormalizer('rate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('ean', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('printEAN', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('unitEAN', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('unitCoefEAN', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('deliveryTime', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setNormalizer('minQuantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new SupplierItemDto();
    }
}
