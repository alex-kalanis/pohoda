<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Receipt;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new SummaryDto();
    }
}
