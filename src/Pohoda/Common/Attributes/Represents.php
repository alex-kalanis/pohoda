<?php

namespace Riesenia\Pohoda\Common\Attributes;

use Attribute;

/**
 * The variable is used as representation of different one
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class Represents
{
    /**
     * @param string|string[] $differentVariable
     */
    public function __construct(
        public readonly string|array $differentVariable,
    ) {}
}
