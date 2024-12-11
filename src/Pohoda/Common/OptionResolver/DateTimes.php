<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class DateTimes extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'Y-m-d\TH:i:s';
    }
}
