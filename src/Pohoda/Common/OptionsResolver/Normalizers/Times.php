<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

final class Times extends AbstractDates
{
    protected function getFormat(): string
    {
        return 'H:i:s';
    }
}
