<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class Strings extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        // remove new lines
        $value = \str_replace(["\r\n", "\r", "\n"], ' ', \strval($value));

        // param is used for string length
        $length = empty($this->config['length']) ? null : \intval($this->config['length']);
        return \mb_substr(\strval($value), 0, $length, 'utf-8');
    }
}
