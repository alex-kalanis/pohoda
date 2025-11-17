<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Attribute;
use Riesenia\Pohoda\Common\OptionsResolver\Normalizers\Integers;

/**
 * Property will be formatted as interger
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class IntegerOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Integers::class;
    }
}
