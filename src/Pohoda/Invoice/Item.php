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
    protected array $refElements = [
        'typeServiceMOSS',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'centre',
        'activity',
        'contract',
    ];

    /** @var string[] */
    protected array $elements = [
        'text',
        'quantity',
        'unit',
        'coefficient',
        'payVAT',
        'rateVAT',
        'percentVAT',
        'discountPercentage',
        'homeCurrency',
        'foreignCurrency',
        'typeServiceMOSS',
        'note',
        'code',
        'guarantee',
        'guaranteeType',
        'stockItem',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'centre',
        'activity',
        'contract',
        'expirationDate',
        'PDP',
        'recyclingContrib',
    ];

    /**
     * @inheritdoc
     */
    public function setData(array $data): parent
    {
        if (isset($data['recyclingContrib'])) {
            $recyclingContrib = new RecyclingContrib($this->dependenciesFactory);
            $recyclingContrib
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data['recyclingContrib']);
            $data['recyclingContrib'] = $recyclingContrib;
        }

        return parent::setData($data);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('quantity', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('unit', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string10'));
        $resolver->setNormalizer('coefficient', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('payVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setAllowedValues('rateVAT', ['none', 'high', 'low', 'third', 'historyHigh', 'historyLow', 'historyThird']);
        $resolver->setNormalizer('percentVAT', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('discountPercentage', $this->dependenciesFactory->getNormalizerFactory()->getClosure('float'));
        $resolver->setNormalizer('note', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string90'));
        $resolver->setNormalizer('code', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string64'));
        $resolver->setNormalizer('guarantee', $this->dependenciesFactory->getNormalizerFactory()->getClosure('int'));
        $resolver->setAllowedValues('guaranteeType', ['none', 'hour', 'day', 'month', 'year', 'life']);
        $resolver->setNormalizer('expirationDate', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('PDP', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }
}
