<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;

/**
 * Normalization of content
 */
abstract class AbstractNormalizer
{
    protected int|null $length = null;
    protected bool $nullable = false;

    public function setParams(
        int|null $length = null,
        bool $nullable = false,
    ): self {
        $this->length = $length;
        $this->nullable = $nullable;
        return $this;
    }

    /**
     * Normalize that content
     * @param mixed $options
     * @param mixed $value
     * @return string
     */
    abstract public function normalize(mixed $options, mixed $value): string;
}
