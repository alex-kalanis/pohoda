<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Document\Item as DocumentItem;

class Item extends DocumentItem
{
    /** @var string[] */
    protected $_refElements = ['number', 'cashAccount', 'centre', 'activity', 'contract'];

    /** @var string[] */
    protected $_elements = [
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