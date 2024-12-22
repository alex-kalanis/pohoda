<?php
/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Order;


use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;


class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['extId', 'number', 'paymentType', 'priceLevel', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'carrier'];

    /** @var string[] */
    protected array $elements = ['extId', 'orderType', 'number', 'numberOrder', 'date', 'dateDelivery', 'dateFrom', 'dateTo', 'text', 'partnerIdentity', 'myIdentity', 'paymentType', 'priceLevel', 'isExecuted', 'isReserved', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'accountingPeriodMOSS', 'note', 'carrier', 'intNote', 'markRecord', 'histRate'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setDefault('orderType', 'receivedOrder');
        $resolver->setAllowedValues('orderType', ['receivedOrder', 'issuedOrder']);
        $resolver->setNormalizer('numberOrder', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateFrom', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateTo', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string240'));
        $resolver->setNormalizer('isExecuted', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('isReserved', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('histRate', $this->normalizerFactory->getClosure('bool'));
    }
}
