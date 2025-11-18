<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
