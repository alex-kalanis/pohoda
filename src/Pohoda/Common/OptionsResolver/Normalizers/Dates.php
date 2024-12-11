<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


class Dates extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'Y-m-d';
    }
}
