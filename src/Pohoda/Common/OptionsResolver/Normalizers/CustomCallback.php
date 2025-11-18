<?php

namespace kalanis\Pohoda\Common\OptionsResolver\Normalizers;

final class CustomCallback extends AbstractNormalizer
{
    public function normalize(mixed $options, mixed $value): mixed
    {
        if (empty($this->custom) || !is_callable($this->custom)) {
            return '';
        }
        return \call_user_func($this->custom, $options, $value, $this->dto);
    }
}
