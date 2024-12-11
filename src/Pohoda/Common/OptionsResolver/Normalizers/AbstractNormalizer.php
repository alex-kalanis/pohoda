<?php

namespace Riesenia\Pohoda\Common\OptionsResolver\Normalizers;


/**
 * Normalization of content
 */
abstract class AbstractNormalizer
{
    /**
     * @param array{
     *      length?: int|null,
     *      nullable?: bool|null,
     *  } $config
     */
    public function __construct(
        protected readonly array $config,
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
