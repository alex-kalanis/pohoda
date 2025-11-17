<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Attribute;
use Riesenia\Pohoda\Common\OptionsResolver\Normalizers\Dates;

/**
 * Property will be formatted as date
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return Dates::class;
    }
}
