<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


class ParameterName extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        $prefix = 'VPr';
        $options = (array) $options;
        $value = \strval($value);

        if ('list' == $options['type']) {
            $prefix = 'RefVPr';
        }

        if (str_starts_with($value, $prefix)) {
            return $value;
        }

        return $prefix . $value;
    }
}
