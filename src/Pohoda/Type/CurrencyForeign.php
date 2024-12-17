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


class CurrencyForeign extends AbstractAgenda
{
    use SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['currency'];

    /** @var string[] */
    protected array $elements = ['currency', 'rate', 'amount', 'priceSum'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('rate', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('amount', $this->normalizerFactory->getClosure('int'));
        $resolver->setNormalizer('priceSum', $this->normalizerFactory->getClosure('float'));
    }
}
