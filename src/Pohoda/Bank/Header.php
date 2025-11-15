<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = [
        'account',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'paymentAccount',
        'centre',
        'activity',
        'contract',
        'MOSS',
        'evidentiaryResourcesMOSS',
    ];

    /**
     * {@inheritdoc}
     */
    public function setData(?Common\Dtos\AbstractDto $data): parent
    {
        // process report
        if (isset($data->statementNumber)) {
            $statementNumber = new StatementNumber($this->dependenciesFactory);
            $statementNumber
                ->setDirectionalVariable($this->useOneDirectionalVariables)
                ->setResolveOptions($this->resolveOptions)
                ->setData($data->statementNumber);
            $data->statementNumber = $statementNumber;
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
        $resolver->setAllowedValues('bankType', ['receipt', 'expense']);
        $resolver->setNormalizer('symVar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('dateStatement', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('datePayment', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string96'));
        $resolver->setNormalizer('symConst', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string4'));
        $resolver->setNormalizer('symSpec', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string16'));
        $resolver->setNormalizer('symPar', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string20'));
        $resolver->setNormalizer('accountingPeriodMOSS', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string7'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
