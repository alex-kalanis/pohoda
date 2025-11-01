<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Type;

use Riesenia\Pohoda\AbstractAgenda;
use Riesenia\Pohoda\Common;

class CurrencyItem extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->getDataElements());

        // validate / format options
        $resolver->setNormalizer('unitPrice', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('price', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceSum', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\CurrencyItemDto();
    }
}
