<?php

namespace kalanis\Pohoda\Voucher;

use kalanis\Pohoda\Common\Dtos;
use kalanis\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * @{inheritDoc}
     */
    protected function getDefaultDto(): Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
