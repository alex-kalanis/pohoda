<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\Numbers;

/**
 * Property will be formatted as float number
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class FloatOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Numbers::class;
    }
}
