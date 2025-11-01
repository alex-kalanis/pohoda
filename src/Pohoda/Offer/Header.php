<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = [
        'number',
        'priceLevel',
        'centre',
        'activity',
        'contract',
        'regVATinEU',
        'MOSS',
        'evidentiaryResourcesMOSS',
    ];

    /** @var string[] */
    protected array $elements = [
        'offerType',
        'number',
        'date',
        'validTill',
        'text',
        'partnerIdentity',
        'myIdentity',
        'priceLevel',
        'centre',
        'activity',
        'contract',
        'regVATinEU',
        'MOSS',
        'evidentiaryResourcesMOSS',
        'accountingPeriodMOSS',
        'isExecuted',
        'details',
        'note',
        'intNote',
        'markRecord',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setDefault('offerType', 'receivedOffer');
        $resolver->setAllowedValues('offerType', ['receivedOffer', 'issuedOffer']);
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('validTill', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
        $resolver->setNormalizer('isExecuted', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->dependenciesFactory->getNormalizerFactory()->getClosure('bool'));
    }
}
