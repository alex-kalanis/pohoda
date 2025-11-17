<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Attribute;
use Riesenia\Pohoda\Common\OptionsResolver;

/**
 * Property will have default value
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class DefaultOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return OptionsResolver\Normalizers\Strings::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(): OptionsResolver\ActionsEnum
    {
        return OptionsResolver\ActionsEnum::DEFAULT_VALUES;
    }
}
