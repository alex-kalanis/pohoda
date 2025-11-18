<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common\OptionsResolver;

/**
 * Property will be set as required
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class RequiredOption extends AbstractOption
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
        return OptionsResolver\ActionsEnum::IS_REQUIRED;
    }
}
