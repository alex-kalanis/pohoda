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
        $resolver->setNormalizer('priceNone', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('price3', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('price3VAT', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('price3Sum', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceLow', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceLowVAT', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceLowSum', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceHigh', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceHighVAT', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceHighSum', $resolver->getNormalizer('float'));
    }
}
