<?php

namespace kalanis\Pohoda\Common\Attributes;

use Attribute;

/**
 * The variable is used as attribute to target element
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
final class AttributeExtend
{
    public function __construct(
        public readonly string $attrElement,
        public readonly string $attrName,
        public readonly ?string $attrNamespace = null,
    ) {}
}
