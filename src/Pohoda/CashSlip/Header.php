<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\CashSlip;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setDefault('prodejkaType', 'saleVoucher');
        $resolver->setAllowedValues('prodejkaType', ['saleVoucher', 'deposit', 'withdrawal']);
        $resolver->setNormalizer('date', $this->dependenciesFactory->getNormalizerFactory()->getClosure('date'));
        $resolver->setNormalizer('text', $this->dependenciesFactory->getNormalizerFactory()->getClosure('string240'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
