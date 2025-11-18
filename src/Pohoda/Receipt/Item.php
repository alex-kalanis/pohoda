<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Receipt;

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
