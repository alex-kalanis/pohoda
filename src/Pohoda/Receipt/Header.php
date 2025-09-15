<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /** @var string[] */
    protected array $refElements = ['number', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = ['number', 'date', 'dateOfReceipt', 'text', 'partnerIdentity', 'symPar', 'centre', 'activity', 'contract', 'note', 'intNote'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setNormalizer('date', $this->normalizerFactory->getClosure('date'));
        $resolver->setNormalizer('dateOfReceipt', $this->normalizerFactory->getClosure('?date'));
        $resolver->setNormalizer('symPar', $this->normalizerFactory->getClosure('string20'));
        $resolver->setNormalizer('text', $this->normalizerFactory->getClosure('string240'));
    }
}
