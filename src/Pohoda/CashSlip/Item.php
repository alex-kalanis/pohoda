<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string255'));
        $resolver->setNormalizer('quantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'third', 'low', 'high']);
        $resolver->setNormalizer('discountPercentage', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('note', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('code', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
