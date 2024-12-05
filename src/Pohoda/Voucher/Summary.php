<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document\Summary as DocumentSummary;

class Summary extends DocumentSummary
{
    /** @var string[] */
    protected $_elements = [
        'roundingDocument',
        'roundingVAT',
        'calculateVAT',
        'typeCalculateVATInclusivePrice',
        'homeCurrency',
        'foreignCurrency',
    ];
}