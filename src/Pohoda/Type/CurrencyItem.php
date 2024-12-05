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

class CurrencyItem extends AbstractAgenda
{
    use SetNamespaceTrait;

    /** @var string[] */
    protected array $elements = ['unitPrice', 'price', 'priceVAT', 'priceSum'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('unitPrice', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('price', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceVAT', $resolver->getNormalizer('float'));
        $resolver->setNormalizer('priceSum', $resolver->getNormalizer('float'));
    }
}
