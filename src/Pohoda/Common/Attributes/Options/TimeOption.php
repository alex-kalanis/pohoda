<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Attribute;
use Riesenia\Pohoda\Common\OptionsResolver\Normalizers\Times;

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
