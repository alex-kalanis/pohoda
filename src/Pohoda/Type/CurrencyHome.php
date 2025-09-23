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
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class CurrencyHome extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['round'];

    /** @var string[] */
    protected array $elements = ['priceNone', 'price3', 'price3VAT', 'price3Sum', 'priceLow', 'priceLowVAT', 'priceLowVatRate', 'priceLowSum', 'priceHigh', 'priceHighVAT', 'priceHighVatRate', 'priceHighSum', 'round'];

    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        string $companyRegistrationNumber,
        Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'priceLowVatRate' => new Common\ElementAttributes('priceLowVAT', 'rate'),
            'priceHighVatRate' => new Common\ElementAttributes('priceHighVAT', 'rate'),
        ];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $normalizerFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
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
        $resolver->setNormalizer('priceLowVatRate', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceLowSum', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHigh', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHighVAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHighVatRate', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('priceHighSum', $this->normalizerFactory->getClosure('float'));
    }
}
