<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


class Strings extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        // remove new lines
        $value = \str_replace(["\r\n", "\r", "\n"], ' ', \strval($value));

        // param is used for string length
        $length = empty($this->length) ? null : \intval($this->length);
        return \mb_substr(\strval($value), 0, $length, 'utf-8');
    }
}
