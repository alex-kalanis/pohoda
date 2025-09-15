<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Bank;

use Riesenia\Pohoda\Common\OptionsResolver;
use Riesenia\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    /** @var string[] */
    protected array $elements = ['roundingDocument', 'roundingVAT', 'homeCurrency', 'foreignCurrency'];

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setAllowedValues('roundingDocument', ['none']);
        $resolver->setAllowedValues('roundingVAT', ['none']);
    }
}
