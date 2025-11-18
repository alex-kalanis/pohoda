<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver;

/**
 * Property will be formatted as string and selected just from predefined list
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ListOption extends AbstractOption
{
    /**
     * @codeCoverageIgnore just implements interface, not need in processing
     * @return string
     */
    public function getNormalizer(): string
    {
        return OptionsResolver\Normalizers\Strings::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(): OptionsResolver\ActionsEnum
    {
        return OptionsResolver\ActionsEnum::ALLOWED_VALUES;
    }
}
