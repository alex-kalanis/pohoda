<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = ['centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['quantity', 'unit', 'coefficient', 'payVAT', 'rateVAT', 'discountPercentage', 'homeCurrency', 'foreignCurrency', 'code', 'stockItem', 'note', 'centre', 'activity', 'contract'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('discountPercentage', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('code', $this->normalizerFactory->getClosure('string64'));
        $resolver->setNormalizer('note', $this->normalizerFactory->getClosure('string90'));
    }
}
