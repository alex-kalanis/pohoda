<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IssueSlip;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['number', 'priceLevel', 'paymentType', 'centre', 'activity', 'contract', 'carrier', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS'];

    /** @var string[] */
    protected array $elements = ['number', 'date', 'numberOrder', 'dateOrder', 'text', 'partnerIdentity', 'acc', 'symPar', 'priceLevel', 'paymentType', 'isExecuted', 'isDelivered', 'centre', 'activity', 'contract', 'carrier', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'accountingPeriodMOSS', 'note', 'intNote', 'histRate'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('numberOrder', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('dateOrder', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string240'));
        $resolver->setNormalizer('acc', $this->normalizerFactory->getClosure('string9'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('isExecuted', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('isDelivered', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('histRate', $this->normalizerFactory->getClosure('bool'));
    }
}
