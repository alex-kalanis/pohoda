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

class StockItem extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /** @var string[] */
    protected array $refElements = ['store', 'stockItem'];

    /** @var string[] */
    protected array $elements = ['store', 'stockItem', 'insertAttachStock', 'applyUserSettingsFilterOnTheStore', 'serialNumber'];

    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
        Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'insertAttachStock' => new Common\ElementAttributes('stockItem', 'insertAttachStock'),
            'applyUserSettingsFilterOnTheStore' => new Common\ElementAttributes('stockItem', 'applyUserSettingsFilterOnTheStore'),
        ];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $resolveOptions, $normalizerFactory);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        // available options
        $resolver->setDefined($this->elements);

        // validate / format options
        $resolver->setNormalizer('insertAttachStock', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('applyUserSettingsFilterOnTheStore', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('serialNumber', $this->normalizerFactory->getClosure('string40'));
    }
}
