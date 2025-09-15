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
use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Common\SetNamespaceTrait;

class CurrencyHome extends AbstractAgenda
{
    use SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['round'];

    /** @var string[] */
    protected array $elements = ['priceNone', 'price3', 'price3VAT', 'price3Sum', 'priceLow', 'priceLowVAT', 'priceLowSum', 'priceHigh', 'priceHighVAT', 'priceHighSum', 'round'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('priceNone', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('price3', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('price3VAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('price3Sum', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceLow', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceLowVAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceLowSum', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHigh', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHighVAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHighSum', $this->normalizerFactory->getClosure('float'));
    }
}
