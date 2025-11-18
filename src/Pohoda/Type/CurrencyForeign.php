<?php

declare(strict_types=1);

namespace kalanis\Pohoda\Type;

use kalanis\Pohoda\AbstractAgenda;
use kalanis\Pohoda\Common;

class CurrencyForeign extends AbstractAgenda
{
    use Common\SetNamespaceTrait;

    /**
     * {@inheritDoc}
     */
    protected function getDefaultDto(): Common\Dtos\AbstractDto
    {
        return new Dtos\CurrencyForeignDto();
    }
}
