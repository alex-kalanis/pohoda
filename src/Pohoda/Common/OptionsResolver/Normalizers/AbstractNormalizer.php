<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


/**
 * Normalization of content
 */
abstract class AbstractNormalizer
{
    public function __construct(
        protected readonly int|null $length,
        protected readonly bool $nullable,
    )
    {
    }

    /**
     * Normalize that content
     * @param mixed $options
     * @param mixed $value
     * @return string
     */
    abstract public function normalize(mixed $options, mixed $value): string;
}
