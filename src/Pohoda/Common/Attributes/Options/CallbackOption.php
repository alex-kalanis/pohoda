<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver\Normalizers\CustomCallback;

/**
 * Property will use callback for formatting
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class CallbackOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return CustomCallback::class;
    }
}
