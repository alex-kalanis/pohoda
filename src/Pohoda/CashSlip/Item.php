<?php

declare(strict_types=1);

namespace kalanis\Pohoda\CashSlip;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractItem;

class Item extends AbstractItem
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new ItemDto();
    }
}
