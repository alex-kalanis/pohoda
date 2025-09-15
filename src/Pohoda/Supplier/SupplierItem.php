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
use Riesenia\Pohoda\Common\OptionsResolver;

class SupplierItem extends AbstractAgenda
{
    /** @var string[] */
    protected array $refElements = ['refAd', 'currency', 'deliveryPeriod'];

    /** @var string[] */
    protected array $elements = ['default', 'refAd', 'orderCode', 'orderName', 'purchasingPrice', 'currency', 'rate', 'payVAT', 'ean', 'printEAN', 'unitEAN', 'unitCoefEAN', 'deliveryTime', 'deliveryPeriod', 'minQuantity', 'unit', 'note'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('sup:supplierItem', '', $this->namespace('sup'));

        // handle default
        if ($this->data['default']) {
            $xml->addAttribute('default', strval($this->data['default']));
            unset($this->data['default']);
        }

        $this->addElements($xml, $this->elements, 'sup');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        $resolver->setNormalizer('default', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('orderCode', $this->normalizerFactory->getClosure('string64'));
        $resolver->setNormalizer('orderName', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('purchasingPrice', $this->normalizerFactory->getClosure('number'));
        $resolver->setNormalizer('rate', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('ean', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('printEAN', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('unitEAN', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('unitCoefEAN', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('deliveryTime', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('minQuantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
    }
}
