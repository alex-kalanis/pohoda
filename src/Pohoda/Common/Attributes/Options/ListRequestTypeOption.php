<?php

namespace Riesenia\Pohoda\Common\Attributes\Options;

use Attribute;
use Riesenia\Pohoda\Common\OptionsResolver;

/**
 * Property will be formatted as string and selected just from predefined list
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class ListRequestTypeOption extends AbstractOption
{
    public function getNormalizer(): string
    {
        return OptionsResolver\Normalizers\ListRequestType::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(): OptionsResolver\ActionsEnum
    {
        return OptionsResolver\ActionsEnum::NORMALIZER;
    }
}
