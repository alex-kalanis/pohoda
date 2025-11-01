<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

final class DateTimes extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'Y-m-d\TH:i:s';
    }
}
