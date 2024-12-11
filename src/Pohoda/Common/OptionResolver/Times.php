<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class Times extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'H:i:s';
    }
}
