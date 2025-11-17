<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Riesenia\Pohoda\Common\OptionsResolver\ActionsEnum;

/**
 * These children will set rules for normalization
 */
abstract class AbstractOption
{
    public function __construct(
        public readonly mixed $value = null,
        public readonly bool $isNullable = false,
    ) {}

    /**
     * @return class-string<object>
     */
    abstract public function getNormalizer(): string;

    /**
     * What kind of operation will be used
     *
     * @return ActionsEnum
     */
    public function getAction(): ActionsEnum
    {
        return ActionsEnum::NORMALIZER;
    }
}
