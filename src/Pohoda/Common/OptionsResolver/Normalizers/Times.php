<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


class Times extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'H:i:s';
    }
}
