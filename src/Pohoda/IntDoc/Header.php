<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\IntDoc;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['number', 'accounting', 'classificationVAT', 'classificationKVDPH', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS'];

    /** @var string[] */
    protected array $elements = ['number', 'symVar', 'symPar', 'originalDocumentNumber', 'originalCorrectiveDocument', 'date', 'dateTax', 'dateAccounting', 'dateDelivery', 'dateKVDPH', 'dateKHDPH', 'accounting', 'classificationVAT', 'classificationKVDPH', 'numberKHDPH', 'text', 'partnerIdentity', 'myIdentity', 'liquidation', 'centre', 'activity', 'contract', 'regVATinEU', 'MOSS', 'evidentiaryResourcesMOSS', 'accountingPeriodMOSS', 'note', 'intNote', 'markRecord'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('symVar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateTax', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateAccounting', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateDelivery', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateKVDPH', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateKHDPH', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('numberKHDPH', $this->normalizerFactory->getClosure('string32'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string240'));
        $resolver->setNormalizer('liquidation', $this->normalizerFactory->getClosure('bool'));
        $resolver->setNormalizer('markRecord', $this->normalizerFactory->getClosure('bool'));
    }
}
