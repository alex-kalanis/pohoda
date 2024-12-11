<?php

namespace Riesenia\Pohoda\Common\OptionResolver;


class Booleans extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        if (!empty($this->config['nullable']) && empty($value) && !\is_bool($value)) {
            return '';
        }
        return !$value || \is_string($value) && 'false' === \strtolower($value) ? 'false' : 'true';
    }
}
