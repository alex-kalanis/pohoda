<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document\AbstractSummary;

class Summary extends AbstractSummary
{
    /** @var string[] */
    protected array $elements = [
        'roundingDocument',
        'roundingVAT',
        'calculateVAT',
        'typeCalculateVATInclusivePrice',
        'homeCurrency',
        'foreignCurrency',
    ];
}
