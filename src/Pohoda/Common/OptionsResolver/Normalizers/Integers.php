<?php

namespace kalanis\Pohoda\Common\OptionsResolver\Normalizers;

final class Integers extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        $preform = \strval(
            \preg_replace(
                '/[^0-9,.-]/',
                '',
                \strval($value),
            ),
        );
        if ($this->nullable && empty(\strlen($preform))) {
            return '';
        }
        return \strval(
            \intval(
                \str_replace(
                    ',',
                    '.',
                    $preform,
                ),
            ),
        );
    }
}
