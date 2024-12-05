<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document\AbstractSummary as DocumentSummary;

class Summary extends DocumentSummary
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