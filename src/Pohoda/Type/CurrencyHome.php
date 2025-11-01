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
use Riesenia\Pohoda\DI\DependenciesFactory;

class CurrencyHome extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = [
        'round',
    ];

    /** @var string[] */
    protected array $elements = [
        'priceNone',
        'price3',
        'price3VAT',
        'price3Sum',
        'priceLow',
        'priceLowVAT',
        'priceLowVatRate',
        'priceLowSum',
        'priceHigh',
        'priceHighVAT',
        'priceHighVatRate',
        'priceHighSum',
        'round',
    ];

    public function __construct(
        DependenciesFactory $dependenciesFactory,
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'priceLowVatRate' => new Common\ElementAttributes('priceLowVAT', 'rate'),
            'priceHighVatRate' => new Common\ElementAttributes('priceHighVAT', 'rate'),
        ];

        parent::__construct($dependenciesFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('priceNone', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('price3', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('price3VAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('price3Sum', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceLow', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceLowVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceLowVatRate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceLowSum', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceHigh', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceHighVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceHighVatRate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('priceHighSum', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
    }
}
