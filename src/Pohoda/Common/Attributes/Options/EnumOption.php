<?php

namespace kalanis\Pohoda\Common\Attributes\Options;

use Attribute;
use kalanis\Pohoda\Common;
use kalanis\Pohoda\Common\OptionsResolver;
use kalanis\PohodaException;

/**
 * Property will be formatted as string and selected just from predefined enum
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class EnumOption extends AbstractOption
{
    /**
     * @param class-string<object> $value
     * @throws PohodaException
     */
    public function __construct(
        string $value,
    ) {
        if (!is_a($value, Common\Enums\EnhancedEnumInterface::class, true)) {
            throw new PohodaException('The value must be an enum instance!');
        }
        parent::__construct($value);
    }

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
        return OptionsResolver\ActionsEnum::ALLOWED_ENUMS;
    }
}
