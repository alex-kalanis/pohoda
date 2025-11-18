<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Offer;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new SummaryDto();
    }
}
