<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\Strings;

/**
 * Property will be formatted as string with correct limitations
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class StringOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Strings::class;
    }
}
