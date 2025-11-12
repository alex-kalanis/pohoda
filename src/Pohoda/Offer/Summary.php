<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Offer;

use Riesenia\Pohoda\Common;
use Riesenia\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(Common\OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        // validate / format options
        $resolver->setAllowedValues('roundingDocument', ['none', 'math2one', 'math2half', 'math2tenth', 'math5cent', 'up2one', 'up2half', 'up2tenth', 'down2one', 'down2half', 'down2tenth']);
        $resolver->setAllowedValues('roundingVAT', ['none', 'noneEveryRate', 'up2tenthEveryItem', 'up2tenthEveryRate', 'math2tenthEveryItem', 'math2tenthEveryRate', 'math2halfEveryItem', 'math2halfEveryRate', 'math2intEveryItem', 'math2intEveryRate']);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new SummaryDto();
    }
}
