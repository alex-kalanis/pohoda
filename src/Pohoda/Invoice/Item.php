<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Invoice;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractItem;
use Riesenia\Pohoda\Type\RecyclingContrib;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = ['typeServiceMOSS', 'accounting', 'classificationVAT', 'classificationKVDPH', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['text', 'quantity', 'unit', 'coefficient', 'payVAT', 'rateVAT', 'percentVAT', 'discountPercentage', 'homeCurrency', 'foreignCurrency', 'typeServiceMOSS', 'note', 'code', 'guarantee', 'guaranteeType', 'stockItem', 'accounting', 'classificationVAT', 'classificationKVDPH', 'centre', 'activity', 'contract', 'expirationDate', 'PDP', 'recyclingContrib'];

    /**
     * @inheritdoc
     */
    public function __construct(Common\NamespacesPaths $namespacesPaths, array $data, string $ico, bool $resolveOptions = true) {
        if (isset($data['recyclingContrib'])) {
            $data['recyclingContrib'] = new RecyclingContrib($namespacesPaths, $data['recyclingContrib'], $ico, $resolveOptions);
        }

        parent::__construct($namespacesPaths, $data, $ico, $resolveOptions);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('quantity', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('unit', $this->normalizerFactory->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->normalizerFactory->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird']);
        $resolver->setNormalizer('percentVAT', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('discountPercentage', $this->normalizerFactory->getClosure('float'));
        $resolver->setNormalizer('note', $this->normalizerFactory->getClosure('string90'));
        $resolver->setNormalizer('code', $this->normalizerFactory->getClosure('string64'));
        $resolver->setNormalizer('guarantee', $this->normalizerFactory->getClosure('int'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('expirationDate', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('PDP', $this->normalizerFactory->getClosure('bool'));
    }
}
