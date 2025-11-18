<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new SummaryDto();
    }
}
