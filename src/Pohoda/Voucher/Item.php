<?php

namespace Riesenia\Pohoda\Voucher;

use Riesenia\Pohoda\Common\Dtos;
use Riesenia\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /** @var string[] */
    protected array $refElements = [
        'number',
        'cashAccount',
        'centre',
        'activity',
        'contract',
    ];

    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
