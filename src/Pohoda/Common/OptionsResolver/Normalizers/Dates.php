<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

final class Dates extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'Y-m-d';
    }
}
