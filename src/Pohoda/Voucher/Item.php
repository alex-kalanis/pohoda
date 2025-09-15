<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = ['number', 'cashAccount', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected array $elements = [
        'text',
        'quantity',
        'unit',
        'coefficient',
        'payVAT',
        'rateVAT',
        'percentVAT',
        'discountPercentage',
        'homeCurrency',
        'foreignCurrency',
        'typeServiceMOSS',
        'note',
        'code',
        'symPar',
        'stockItem',
        'accounting',
        'classificationVAT',
        'classificationKVDPH',
        'PDP',
        'CodePDP',
        'recyclingContrib',
        'centre',
        'activity',
        'contract',
        'EETItem',
        'parameters',
    ];
}
