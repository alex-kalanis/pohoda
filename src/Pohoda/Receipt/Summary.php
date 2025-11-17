<?php

/**
 * This file is part of riesenia/pohoda package.
 *
 * Licensed under the MIT License
 * (c) RIESENIA.com
 */

declare(strict_types=1);

namespace Riesenia\Pohoda\Receipt;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new SummaryDto();
    }
}
