<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class Numbers extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        $preform = \strval(
            \preg_replace(
                '/[^0-9,.-]/',
                '',
                \strval($value)
            )
        );
        if (!empty($this->config['nullable']) && empty(\strlen($preform))) {
            return '';
        }
        return \str_replace(
            ',',
            '.',
            \strval(
                \floatval(
                    \str_replace(
                        ',',
                        '.',
                        $preform
                    )
                )
            )
        );
    }
}
