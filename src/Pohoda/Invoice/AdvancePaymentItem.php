<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Invoice;


use Riesenia\Pohoda\Common\OptionsResolver;


class AdvancePaymentItem extends Item
{
    /** @var string[] */
    protected array $refElements = ['sourceDocument', 'accounting', 'classificationVAT', 'classificationKVDPH', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['sourceDocument', 'quantity', 'payVAT', 'rateVAT', 'discountPercentage', 'homeCurrency', 'foreignCurrency', 'note', 'accounting', 'classificationVAT', 'classificationKVDPH', 'centre', 'activity', 'contract', 'symPar'];

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        $xml = $this->createXML()->addChild('inv:invoiceAdvancePaymentItem', '', $this->namespace('inv'));

        $this->addElements($xml, \array_merge($this->elements, ['parameters']), 'inv');

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('discountPercentage', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('note', $this->normalizerFactory->getClosure('string90'));
    }
}
