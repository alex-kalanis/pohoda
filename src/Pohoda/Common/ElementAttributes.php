<?php

namespace Riesenia\Pohoda\Common;


/**
 * DTO for element attributes
 */
class ElementAttributes
{
    public function __construct(
        public readonly string $attrElement = '',
        public readonly string $attrName = '',
        public readonly ?string $attrNamespace = null,
    )
    {
    }
}
