<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\DateTimes;

/**
 * Property will be formatted as date and time
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class DateTimeOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return DateTimes::class;
    }
}
