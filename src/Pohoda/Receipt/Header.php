<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Receipt;

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
