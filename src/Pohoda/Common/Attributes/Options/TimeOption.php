<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\Times;

/**
 * Property will be formatted as time
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class TimeOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Times::class;
    }
}
