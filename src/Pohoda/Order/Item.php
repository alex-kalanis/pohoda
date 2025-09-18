<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Order;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractItem;
use Riesenia\Pohoda\ValueTransformer\SanitizeEncoding;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = ['typeServiceMOSS', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['text', 'quantity', 'delivered', 'unit', 'coefficient', 'payVAT', 'rateVAT', 'rateVatValue', 'percentVAT', 'discountPercentage', 'homeCurrency', 'foreignCurrency', 'typeServiceMOSS', 'note', 'code', 'stockItem', 'centre', 'activity', 'contract', 'PDP'];

    /** @var string[] */
    protected array $additionalElements = ['id'];

    public function __construct(
        Common\NamespacesPaths $namespacesPaths,
        SanitizeEncoding $sanitizeEncoding,
        string $companyRegistrationNumber,
        bool $resolveOptions = true,
        Common\OptionsResolver\Normalizers\NormalizerFactory $normalizerFactory = new Common\OptionsResolver\Normalizers\NormalizerFactory(),
    ) {
        // init attributes
        $this->elementsAttributesMapper = [
            'rateVatValue' => new Common\ElementAttributes('rateVAT', 'value'),
        ];

        parent::__construct($namespacesPaths, $sanitizeEncoding, $companyRegistrationNumber, $resolveOptions, $normalizerFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getXML(): \SimpleXMLElement
    {
        if (is_null($this->namespace)) {
            throw new \LogicException('Namespace not set.');
        }

        if (is_null($this->nodePrefix)) {
            throw new \LogicException('Node name prefix not set.');
        }

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Item', '', $this->namespace($this->namespace));

        $this->addElements($xml, \array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : []), ['parameters']), $this->namespace);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        $resolver->setDefined(array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : [])));

        // validate / format options
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('delivered', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird']);
        $resolver->setNormalizer('rateVatValue', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('percentVAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('discountPercentage', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('note', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('code', $this->normalizerFactory->getClosure('string64'));
        $resolver->setNormalizer('PDP', $this->normalizerFactory->getClosure('bool'));

        if ($this->useOneDirectionalVariables) {
            $resolver->setNormalizer('id', $this->normalizerFactory->getClosure('int'));
        }
    }
}
