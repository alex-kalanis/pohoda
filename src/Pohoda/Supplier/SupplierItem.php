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

        $resolver->setNormalizer('default', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('orderCode', $resolver->getNormalizer('string64'));
        $resolver->setNormalizer('orderName', $resolver->getNormalizer('string90'));
        $resolver->setNormalizer('purchasingPrice', $resolver->getNormalizer('number'));
        $resolver->setNormalizer('rate', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('payVAT', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('ean', $resolver->getNormalizer('string20'));
        $resolver->setNormalizer('printEAN', $resolver->getNormalizer('bool'));
        $resolver->setNormalizer('unitEAN', $resolver->getNormalizer('string10'));
        $resolver->setNormalizer('unitCoefEAN', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('deliveryTime', $resolver->getNormalizer('int'));
        $resolver->setNormalizer('minQuantity', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('unit', $resolver->getNormalizer('string10'));
    }
}
