<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\Integers;

/**
 * Property will be formatted as integer number
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class IntegerOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Integers::class;
    }
}
