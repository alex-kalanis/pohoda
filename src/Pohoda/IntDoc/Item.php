<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IntDoc;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = [
        'typeServiceMOSS',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'centre',
        'activity',
        'contract',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('quantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird']);
        $resolver->setNormalizer('percentVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('discountPercentage', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('note', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('code', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('PDP', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('CodePDP', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string4'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
