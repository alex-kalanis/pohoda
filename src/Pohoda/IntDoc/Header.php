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
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('symVar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateTax', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateAccounting', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateKVDPH', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('dateKHDPH', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('numberKHDPH', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
        $resolver->setNormalizer('liquidation', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
