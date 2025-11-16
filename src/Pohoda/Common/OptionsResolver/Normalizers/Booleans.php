<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

final class Booleans extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): string
    {
        if ($this->nullable && empty($value) && !\is_bool($value)) {
            return '';
        }
        if (\is_bool($value)) {
            return $this->whichResult($value);
        }
        if (\is_string($value)) {
            return $this->whichResult(!empty($value) && 'false' !== \strtolower($value));
        }
        return $this->whichResult(!empty($value));
    }

    protected function whichResult(bool $value): string
    {
        return $value ? 'true' : 'false';
    }
}
