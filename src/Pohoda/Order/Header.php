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

    /** @var string[] */
    protected array $additionalElements = ['id', 'isDelivered', 'permanentDocument'];

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

        $xml = $this->createXML()->addChild($this->namespace . ':' . $this->nodePrefix . 'Header', '', $this->namespace($this->namespace));

        $this->addElements($xml, \array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : []), ['parameters']), $this->namespace);

        return $xml;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined(array_merge($this->elements, ($this->useOneDirectionalVariables ? $this->additionalElements : [])));

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

        if ($this->useOneDirectionalVariables) {
            $resolver->setNormalizer('id', $this->normalizerFactory->getClosure('int'));
            $resolver->setNormalizer('isDelivered', $this->normalizerFactory->getClosure('bool'));
            $resolver->setNormalizer('permanentDocument', $this->normalizerFactory->getClosure('bool'));
        }
    }
}
