<?php

declare(strict_types=1);

namespace kalanis\Pohoda\IntDoc;

use kalanis\Pohoda\Common;
use kalanis\Pohoda\Document\AbstractHeader;

class Header extends AbstractHeader
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new HeaderDto();
    }
}
