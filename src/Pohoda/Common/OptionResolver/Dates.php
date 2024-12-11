<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class Dates extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'Y-m-d';
    }
}
