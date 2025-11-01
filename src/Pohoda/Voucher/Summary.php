<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Document\AbstractSummary;

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
