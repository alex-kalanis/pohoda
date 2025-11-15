<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IssueSlip;

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
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('numberOrder', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string32'));
        $resolver->setNormalizer('dateOrder', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
        $resolver->setNormalizer('acc', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string9'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('isExecuted', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('isDelivered', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('histRate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
