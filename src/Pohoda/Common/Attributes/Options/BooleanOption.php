<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\Booleans;

/**
 * Property will be formatted into boolean values
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class BooleanOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Booleans::class;
    }
}
